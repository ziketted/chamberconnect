<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Chamber;

class MembershipApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Chamber $chamber) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre adhésion a été approuvée')
            ->greeting('Bonjour ' . ($notifiable->name ?? ''))
            ->line('Votre demande d’adhésion à la chambre "' . $this->chamber->name . '" a été approuvée.')
            ->action('Voir la chambre', route('chamber.show', $this->chamber))
            ->line('Bienvenue !');
    }
}




