<?php

namespace App\Mail;

use App\Models\GuestGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GroupRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public GuestGroup $group;
    public ?string $rejectionReason;

    /**
     * Create a new message instance.
     */
    public function __construct(GuestGroup $group, ?string $rejectionReason = null)
    {
        $this->group = $group;
        $this->rejectionReason = $rejectionReason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Estado de Solicitud: ' . $this->group->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.group-rejected',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}