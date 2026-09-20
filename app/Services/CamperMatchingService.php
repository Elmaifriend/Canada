<?php

namespace App\Services;

use App\Models\Camper;
use Illuminate\Support\Str;

class CamperMatchingService
{
    /**
     * Busca el Camper más probable aplicando prioridades por coincidencia.
     */
    public function findBestMatch(array $camperData, array $guardianIds = []): ?Camper
    {
        $firstName = trim($camperData['first_name'] ?? '');
        $lastName = trim($camperData['last_name'] ?? '');
        $dob = ! empty($camperData['date_of_birth']) ? $camperData['date_of_birth'] : null;
        $healthCard = trim($camperData['health_card_number'] ?? '');

        // 🥇 TIER 1: Coincidencia por documento único / número de tarjeta de salud
        if (! empty($healthCard)) {
            $match = Camper::where('health_card_number', $healthCard)->first();
            if ($match) {
                return $match;
            }
        }

        // Si no hay fecha de nacimiento o nombres mínimos, detenemos la búsqueda profunda
        if (empty($firstName) || empty($lastName) || empty($dob)) {
            return null;
        }

        // 🥈 TIER 2: Nombre + Apellido + Fecha de Nacimiento + Mismo Tutor Histórico
        if (! empty($guardianIds)) {
            $match = Camper::where('first_name', 'LIKE', $firstName)
                ->where('last_name', 'LIKE', $lastName)
                ->where('date_of_birth', $dob)
                ->whereHas('guardians', function ($q) use ($guardianIds) {
                    $q->whereIn('guardians.id', $guardianIds);
                })
                ->first();

            if ($match) {
                return $match;
            }
        }

        // 🥉 TIER 3: Nombre + Apellido + Fecha de Nacimiento (Deduplicación por identidad única)
        // Coincidencia exacta de triada biográfica
        $match = Camper::where('first_name', 'LIKE', $firstName)
            ->where('last_name', 'LIKE', $lastName)
            ->where('date_of_birth', $dob)
            ->first();

        if ($match) {
            return $match;
        }

        // 🏅 TIER 4 (Opcional): Tolerancia a typos menores (ej. Soundex / Similar text)
        // Se puede implementar si los usuarios suelen cometer faltas de ortografía frecuentes.

        return null;
    }
}