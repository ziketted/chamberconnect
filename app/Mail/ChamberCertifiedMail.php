<?php

namespace App\Mail;

use App\Models\Chamber;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChamberCertifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $chamber;
    public $manager;

    /**
     * Create a new message instance.
     */
    public function __construct(Chamber $chamber, User $manager)
    {
        $this->chamber = $chamber;
        $this->manager = $manager;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Certification - Chambre {$this->chamber->name} - Numéro d'État: {$this->chamber->state_number}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.chamber-certified',
            with: [
                'chamber' => $this->chamber,
                'manager' => $this->manager,
                'stateNumber' => $this->chamber->state_number,
                'certificationDate' => $this->chamber->certification_date?->format('d/m/Y'),
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

