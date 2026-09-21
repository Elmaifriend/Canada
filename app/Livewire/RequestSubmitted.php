<?php

namespace App\Livewire;

use App\Models\GuestGroup;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Application Submitted Successfully')]
class RequestSubmitted extends Component
{
    public ?GuestGroup $group = null;

    public function mount(?string $token = null): void
    {
        // Prioriza el token recibido por la sesión (flash) o directamente por la URL
        $groupToken = session('guest_group_token') ?? $token;

        if ($groupToken) {
            $this->group = GuestGroup::with([
                'members', 
                'events.serviceRequests',
            ])
            ->where('token', $groupToken)
            ->first();
        }

        // Si no existe un grupo correspondiente en la sesión o URL, redirige al inicio
        if (! $this->group) {
            $this->redirect('/', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.request-submitted');
    }
}