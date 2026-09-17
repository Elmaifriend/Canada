<div class="w-full max-w-4xl mx-auto py-10 px-4 sm:px-6">
    <div class="bg-white shadow-md rounded-2xl p-6 sm:p-10 border border-emerald-100 text-center">
        <!-- Ícono de Éxito -->
        <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 text-[#135860] rounded-full mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h2 class="text-2xl sm:text-3xl font-heading font-bold text-slate-900 mb-2">
            {{ $isEditing ? '¡Registro actualizado exitosamente!' : '¡Registro completado con éxito!' }}
        </h2>
        
        <p class="text-slate-600 text-base sm:text-lg max-w-xl mx-auto mb-8">
            El registro para el evento <strong>{{ $eventName }}</strong> se procesó correctamente. Te hemos enviado un correo electrónico con todos los detalles y las instrucciones para gestionar o modificar tu información.
        </p>

        <!-- Botón de Acción -->
        <button 
            type="button" 
            wire:click="registerAnother" 
            class="bg-[#135860] hover:bg-[#0d434a] text-white font-heading font-bold px-8 py-3.5 rounded-2xl transition-all shadow-md active:scale-[0.98]">
            Registrar otra familia
        </button>
    </div>
</div>