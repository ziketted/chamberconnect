<?php

namespace App\Mail;

use App\Models\Chamber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChamberRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $chamber;
    public $rejectionReason;

    /**
     * Create a new message instance.
     */
    public function __construct(Chamber $chamber, string $rejectionReason)
    {
        $this->chamber = $chamber;
        $this->rejectionReason = $rejectionReason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Refus de votre demande de création de chambre',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.chamber-rejected',
            with: [
                'chamber' => $this->chamber,
                'rejectionReason' => $this->rejectionReason,
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