<?php

namespace App\Mail;

use App\Models\GuestGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GroupApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public GuestGroup $group;

    /**
     * Create a new message instance.
     */
    public function __construct(GuestGroup $group)
    {
        $this->group = $group;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Solicitud Aprobada! - ' . $this->group->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.group-approved',
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