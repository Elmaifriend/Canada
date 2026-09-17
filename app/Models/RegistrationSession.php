<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

class RegistrationSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'camp_event_id',
        'token',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($session) {
            if (empty($session->token)) {
                $session->token = Str::random(40);
            }
        });
    }

    public static function getLatestActive(): ?self
    {
        return static::whereHas('campEvent', function ($query) {
            $query->where('is_active', true);
        })->latest()->first();
    }

    public function campEvent(): BelongsTo
    {
        return $this->belongsTo(CampEvent::class);
    }

    /**
     * Inscripciones vinculadas a esta sesión de formulario
     */
    public function camperRegistrations(): BelongsToMany
    {
        return $this->belongsToMany(
            CamperRegistration::class,
            'camper_registration_session',
            'registration_session_id',
            'camper_registration_id'
        )->withTimestamps();
    }

    /**
     * Tutores asociados a esta sesión
     */
    public function guardians(): BelongsToMany
    {
        return $this->belongsToMany(Guardian::class, 'guardian_registration_session')
            ->withPivot(['relationship_type', 'is_primary_guardian', 'is_emergency_contact'])
            ->withTimestamps();
    }

    /**
     * Acceso directo a los acampantes a través de sus inscripciones en la sesión
     */
    public function campers(): HasManyThrough
    {
        return $this->hasManyThrough(
            Camper::class,
            CamperRegistration::class,
            'id', // Local key temporal (filtrado por la relación pivot)
            'id', // Local key en Camper
            'id', // Local key en RegistrationSession
            'camper_id' // Foreign key en CamperRegistration
        )->whereIn('camper_registrations.id', $this->camperRegistrations()->pluck('camper_registrations.id'));
    }
}