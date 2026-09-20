<?php

namespace App\Mail;

use App\Models\RegistrationSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class RegistrationConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public RegistrationSession $session;

    public function __construct(RegistrationSession $session)
    {
        $this->session = $session;
    }

    public function envelope(): Envelope
    {
        // Cargar relación si no existe al procesar desde la cola
        $this->session->loadMissing('campEvent');
        $eventName = $this->session->campEvent->name ?? 'Campamento';

        return new Envelope(
            subject: "Confirmación de Registro - {$eventName}",
        );
    }

    public function content(): Content
    {
        $editUrl = URL::temporarySignedRoute(
            'public.camper.edit',
            now()->addDays(15),
            ['token' => $this->session->token]
        );

        return new Content(
            view: 'emails.registration-confirmation',
            with: [
                'editUrl' => $editUrl,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}