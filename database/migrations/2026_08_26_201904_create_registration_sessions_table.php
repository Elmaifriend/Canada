<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sesión de inscripción familiar/grupo
        Schema::create('registration_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camp_event_id')->constrained('camp_events')->cascadeOnDelete();
            $table->string('token', 64)->unique();
            $table->string('status')->default('pending'); // pending, completed, cancelled
            $table->timestamps();
        });

        // Pivote: Inscripciones individuales (CamperRegistration) asociadas a la Sesión
        Schema::create('camper_registration_session', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_session_id')->constrained()->cascadeOnDelete();
            $table->foreignId('camper_registration_id')->constrained('camper_registrations')->cascadeOnDelete();
            $table->timestamps();
            
            // Garantiza que un registro no se duplique en la misma sesión
            $table->unique(['registration_session_id', 'camper_registration_id'], 'session_registration_unique');
        });

        // Pivote: Tutores / Contactos asociados a la Sesión
        Schema::create('guardian_registration_session', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_session_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guardian_id')->constrained()->cascadeOnDelete();
            
            // Atributos de contexto del tutor en esta sesión
            $table->string('relationship_type')->nullable(); // father, mother, legal_guardian, etc.
            $table->boolean('is_primary_guardian')->default(false);
            $table->boolean('is_emergency_contact')->default(true);
            
            $table->timestamps();

            $table->unique(['registration_session_id', 'guardian_id'], 'session_guardian_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guardian_registration_session');
        Schema::dropIfExists('camper_registration_session');
        Schema::dropIfExists('registration_sessions');
    }
};