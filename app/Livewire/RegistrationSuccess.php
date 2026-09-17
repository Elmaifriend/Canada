<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class RegistrationSuccess extends Component
{
    public string $eventName = '';
    public bool $isEditing = false;

    public function mount(): void
    {
        // Validamos que exista la bandera de éxito en la sesión
        if (! session('success_completed', false)) {
            $this->redirectRoute('public.camper.register');
            return;
        }

        $this->eventName = session('success_event_name', 'Camp Session');
        $this->isEditing = session('success_is_editing', false);
    }

    public function registerAnother(): void
    {
        $this->redirectRoute('public.camper.register');
    }

    #[Layout('layouts.public', ['title' => 'Registro Exitoso'])]
    public function render()
    {
        return view('livewire.registration-success');
    }
}