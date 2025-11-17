<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Event;

class EventPublished extends Notification
{
    use Queueable;

    public function __construct(public Event $event, public string $action = 'created') {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $title = $this->action === 'updated' ? 'Mise à jour d’un événement' : 'Nouvel événement';
        $subject = $title . ' — ' . $this->event->title;

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.events.published', [
                'subject' => $subject,
                'title' => $this->event->title,
                'action' => $this->action,
                'event' => $this->event->fresh(['chamber']),
                'notifiable' => $notifiable,
                'ctaUrl' => route('chamber.show', $this->event->chamber) . '#events',
            ]);
    }
}
