<?php

namespace App\Mail;

use App\Models\Chamber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChamberApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $chamber;
    public $stateNumber;

    /**
     * Create a new message instance.
     */
    public function __construct(Chamber $chamber, string $stateNumber)
    {
        $this->chamber = $chamber;
        $this->stateNumber = $stateNumber;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Validation de votre chambre sur ChamberConnect DRC',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.chamber-approved',
            with: [
                'chamber' => $this->chamber,
                'stateNumber' => $this->stateNumber,
            ]
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