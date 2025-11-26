<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Chamber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ManagerPromotedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $chamber;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Chamber $chamber = null)
    {
        $this->user = $user;
        $this->chamber = $chamber;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Promotion - Vous êtes maintenant gestionnaire de chambre',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.manager-promoted',
            with: [
                'user' => $this->user,
                'chamber' => $this->chamber,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}

