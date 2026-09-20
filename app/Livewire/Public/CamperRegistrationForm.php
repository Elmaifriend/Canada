<?php

namespace App\Livewire\Public;

use App\Mail\RegistrationConfirmationMail;
use App\Models\CampEvent;
use App\Models\Camper;
use App\Models\CamperConsent;
use App\Models\CamperMedical;
use App\Models\CamperRegistration;
use App\Models\Guardian;
use App\Models\RegistrationSession;
use App\Services\CamperMatchingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Url;
use Livewire\Component;

class CamperRegistrationForm extends Component
{
    public ?string $token = null;

    public bool $isEditing = false;
    public ?int $registration_session_id = null;
    public ?CampEvent $activeEvent = null;

    public array $guardians = [];
    public array $campers = [];

    public function mount(?string $token = null): void
    {
        $targetToken = $token;

        if (! empty($targetToken)) {
            $session = RegistrationSession::with([
                'campEvent',
                'guardians',
                'camperRegistrations.camper.medical',
                'camperRegistrations.consent',
            ])
            ->where('token', $targetToken)
            ->first();

            if ($session) {
                $this->token = $targetToken;
                $this->isEditing = true;
                $this->registration_session_id = $session->id;
                $this->activeEvent = $session->campEvent ?? CampEvent::where('is_active', true)->latest()->first();

                $this->loadRegistrationSessionData($session);

                return;
            }

            session()->flash('warning', 'Enlace de acceso no válido o expirado. Puedes completar un nuevo registro.');
        }

        $this->activeEvent = CampEvent::where('is_active', true)->latest()->first();
        $this->addGuardian();
        $this->addCamper();
    }

    private function loadRegistrationSessionData(RegistrationSession $session): void
    {
        foreach ($session->guardians as $index => $g) {
            $pivot = $g->pivot;
            $this->guardians[] = [
                'id' => $g->id,
                'first_name' => $g->first_name,
                'last_name' => $g->last_name,
                'phone' => $g->phone ?? '',
                'email' => $g->email,
                'address' => $g->address,
                'relationship_type' => $pivot?->relationship_type ?? 'father',
                'is_primary_guardian' => (bool) ($pivot?->is_primary_guardian ?? ($index === 0)),
                'is_emergency_contact' => (bool) ($pivot?->is_emergency_contact ?? true),
                'has_custody' => (bool) $g->has_custody,
            ];
        }

        if (empty($this->guardians)) {
            $this->addGuardian();
        }

        foreach ($session->camperRegistrations as $registration) {
            $camper = $registration->camper;
            if (! $camper) continue;

            $medical = $camper->medical;
            $consent = $registration->consent;

            $dobString = $camper->date_of_birth
                ? (is_string($camper->date_of_birth) ? $camper->date_of_birth : $camper->date_of_birth->format('Y-m-d'))
                : '';

            $genderVal = $camper->gender
                ? (is_object($camper->gender) ? $camper->gender->value : (string) $camper->gender)
                : 'male';

            $this->campers[] = [
                'camper_id' => $camper->id,
                'registration_id' => $registration->id,
                'first_name' => $camper->first_name ?? '',
                'last_name' => $camper->last_name ?? '',
                'gender' => $genderVal,
                'date_of_birth' => $dobString,
                'health_card_number' => $camper->health_card_number ?? '',
                'address' => $camper->address ?? '',
                'custody_details' => $camper->custody_details ?? '',
                'allergies' => $medical?->allergies ?? '',
                'medications' => $medical?->medications ?? '',
                'dietary_restrictions' => $medical?->dietary_restrictions ?? '',
                'critical_alerts' => $medical?->critical_alerts ?? '',
                'photo_permission' => (bool) ($consent?->photo_permission ?? false),
                'travel_permission' => (bool) ($consent?->travel_permission ?? false),
                'contact_permission' => (bool) ($consent?->contact_permission ?? false),
                'medical_permission' => (bool) ($consent?->medical_permission ?? false),
            ];
        }

        if (empty($this->campers)) {
            $this->addCamper();
        }
    }

    public function addGuardian(): void
    {
        $this->guardians[] = [
            'id' => null,
            'first_name' => '',
            'last_name' => '',
            'phone' => '',
            'email' => null,
            'address' => null,
            'relationship_type' => 'father',
            'is_primary_guardian' => count($this->guardians) === 0,
            'is_emergency_contact' => true,
            'has_custody' => false,
        ];
    }

    public function removeGuardian(int $index): void
    {
        if (count($this->guardians) > 1) {
            unset($this->guardians[$index]);
            $this->guardians = array_values($this->guardians);

            $hasPrimary = collect($this->guardians)->contains('is_primary_guardian', true);
            if (! $hasPrimary && isset($this->guardians[0])) {
                $this->guardians[0]['is_primary_guardian'] = true;
            }
        }
    }

    public function addCamper(): void
    {
        $this->campers[] = [
            'camper_id' => null,
            'registration_id' => null,
            'first_name' => '',
            'last_name' => '',
            'gender' => 'male',
            'date_of_birth' => '',
            'health_card_number' => '',
            'address' => '',
            'custody_details' => '',
            'allergies' => '',
            'medications' => '',
            'dietary_restrictions' => '',
            'critical_alerts' => '',
            'photo_permission' => false,
            'travel_permission' => false,
            'contact_permission' => false,
            'medical_permission' => false,
        ];
    }

    public function removeCamper(int $index): void
    {
        if (count($this->campers) > 1) {
            unset($this->campers[$index]);
            $this->campers = array_values($this->campers);
        }
    }

    public function submit(CamperMatchingService $matchingService)
    {
        if (! $this->activeEvent) {
            session()->flash('error', 'No hay ningún evento activo configurado.');
            return;
        }

        $session = null;
        $savedGuardians = [];

        DB::transaction(function () use ($matchingService, &$session, &$savedGuardians) {

            // 1. Crear o recuperar la Sesión Contenedora
            if ($this->isEditing && $this->registration_session_id) {
                $session = RegistrationSession::findOrFail($this->registration_session_id);
            } else {
                $session = RegistrationSession::create([
                    'camp_event_id' => $this->activeEvent->id,
                    'status' => 'pending',
                ]);
            }

            // 2. Procesar Tutores / Guardians
            $guardianSyncData = [];
            $guardianIds = [];

            foreach ($this->guardians as $gData) {
                $email = ! empty($gData['email']) ? trim($gData['email']) : null;

                $guardianData = [
                    'first_name' => trim($gData['first_name'] ?? ''),
                    'last_name' => trim($gData['last_name'] ?? ''),
                    'phone' => trim($gData['phone'] ?? ''),
                    'address' => $gData['address'] ?? null,
                    'has_custody' => (bool) ($gData['has_custody'] ?? false),
                ];

                if (! empty($gData['id'])) {
                    $guardian = Guardian::findOrFail($gData['id']);
                    $guardian->update(array_merge($guardianData, ['email' => $email]));
                } elseif ($email) {
                    $guardian = Guardian::updateOrCreate(
                        ['email' => $email],
                        $guardianData
                    );
                } else {
                    $guardian = Guardian::create(array_merge($guardianData, ['email' => null]));
                }

                $guardianIds[] = $guardian->id;
                $savedGuardians[] = $guardian;

                $guardianSyncData[$guardian->id] = [
                    'relationship_type' => $gData['relationship_type'] ?? 'father',
                    'is_primary_guardian' => (bool) ($gData['is_primary_guardian'] ?? false),
                    'is_emergency_contact' => (bool) ($gData['is_emergency_contact'] ?? true),
                ];
            }

            // Sincronizar tutores con la sesión
            $session->guardians()->sync($guardianSyncData);

            // 3. Procesar Acampantes e Inscripciones Individuales
            $registrationIds = [];

            foreach ($this->campers as $item) {
                $dob = ! empty($item['date_of_birth'])
                    ? \Carbon\Carbon::parse($item['date_of_birth'])->toDateString()
                    : null;

                $camperData = [
                    'first_name' => trim($item['first_name'] ?? ''),
                    'last_name' => trim($item['last_name'] ?? ''),
                    'date_of_birth' => $dob,
                    'gender' => $item['gender'] ?? 'male',
                    'address' => $item['address'] ?? null,
                    'custody_details' => $item['custody_details'] ?? null,
                    'health_card_number' => $item['health_card_number'] ?? null,
                ];

                $camper = null;

                if (! empty($item['camper_id'])) {
                    $camper = Camper::find($item['camper_id']);
                }

                if (! $camper) {
                    $camper = $matchingService->findBestMatch($camperData, $guardianIds);
                }

                if ($camper) {
                    $camper->update($camperData);
                } else {
                    $camper = Camper::create($camperData);
                }

                foreach ($guardianSyncData as $guardianId => $pivotData) {
                    $camper->guardians()->syncWithoutDetaching([
                        $guardianId => [
                            'relationship_type' => $pivotData['relationship_type'],
                            'is_primary_guardian' => $pivotData['is_primary_guardian'],
                            'is_emergency_contact' => $pivotData['is_emergency_contact'],
                        ],
                    ]);
                }

                $registration = CamperRegistration::firstOrCreate(
                    [
                        'camper_id' => $camper->id,
                        'camp_event_id' => $this->activeEvent->id,
                    ],
                    [
                        'status' => 'pending',
                    ]
                );

                $registrationIds[] = $registration->id;

                CamperMedical::updateOrCreate(
                    ['camper_id' => $camper->id],
                    [
                        'allergies' => $item['allergies'] ?? null,
                        'medications' => $item['medications'] ?? null,
                        'dietary_restrictions' => $item['dietary_restrictions'] ?? null,
                        'critical_alerts' => $item['critical_alerts'] ?? null,
                    ]
                );

                CamperConsent::updateOrCreate(
                    ['camper_registration_id' => $registration->id],
                    [
                        'photo_permission' => (bool) ($item['photo_permission'] ?? false),
                        'travel_permission' => (bool) ($item['travel_permission'] ?? false),
                        'contact_permission' => (bool) ($item['contact_permission'] ?? false),
                        'medical_permission' => (bool) ($item['medical_permission'] ?? false),
                        'signed_at' => now(),
                    ]
                );
            }

            $session->camperRegistrations()->sync($registrationIds);
        });

        // 4. Enviar correo a los guardianes (filtrando nulos y repetidos)
        $emailsToNotify = collect($savedGuardians)
            ->pluck('email')
            ->filter() // Elimina los correos nulos o vacíos
            ->unique() // Evita enviar 2 veces si múltiples tutores usan el mismo correo
            ->values();

        foreach ($emailsToNotify as $email) {
            try {
                Mail::to($email)->sendNow(new RegistrationConfirmationMail($session));
            } catch (\Throwable $e) {
                Log::error("Error enviando correo de confirmación a {$email}: " . $e->getMessage());
            }
        }

        session()->flash('success_completed', true); 
        session()->flash('success_event_name', $this->activeEvent->name ?? 'Evento de Campamento');
        session()->flash('success_is_editing', $this->isEditing);

        return $this->redirectRoute('registration.success');
    }

    public function render()
    {
        return view('livewire.public.camper-registration-form', [
            'activeEvent' => $this->activeEvent,
        ])->layout('layouts.public', ['title' => $this->isEditing ? 'Actualizar Inscripción' : 'Inscripción de Acampantes']);
    }
}