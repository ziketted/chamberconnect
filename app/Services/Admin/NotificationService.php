<?php

namespace App\Services\Admin;

use App\Models\Chamber;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * Envoie une notification en masse aux gestionnaires d'une ou plusieurs chambres
     */
    public function sendBulkNotification(string $type, array $recipients, array $data): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        foreach ($recipients as $recipient) {
            try {
                if ($type === 'email') {
                    Mail::raw($data['message'], function ($message) use ($recipient, $data) {
                        $message->to($recipient->email)
                            ->subject($data['subject'] ?? 'Notification');
                    });
                } elseif ($type === 'notification') {
                    // Envoyer une notification interne (dans la DB)
                    $this->sendInternalNotification($recipient, $data);
                }

                $results['success']++;
            } catch (\Exception $e) {
                $results['failed']++;
                $results['errors'][] = [
                    'recipient' => $recipient->email,
                    'error' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }

    /**
     * Envoie une notification interne
     */
    public function sendInternalNotification(User $user, array $data): void
    {
        Notification::send($user, new \App\Notifications\AdminNotification(
            $data['title'] ?? 'Notification',
            $data['message'] ?? '',
            $data['action_url'] ?? null
        ));
    }

    /**
     * Récupère les destinataires basé sur le type
     */
    public function getRecipients(string $recipientType, ?Chamber $chamber = null): array
    {
        $recipients = [];

        if ($recipientType === 'all_chambers') {
            // Tous les gestionnaires de toutes les chambres
            $recipients = User::where('is_admin', User::ROLE_CHAMBER_MANAGER)
                ->get()
                ->toArray();
        } elseif ($recipientType === 'chamber' && $chamber) {
            // Gestionnaires d'une chambre spécifique
            $recipients = $chamber->members()
                ->wherePivot('role', 'manager')
                ->get()
                ->toArray();
        } elseif ($recipientType === 'managers_only') {
            // Tous les gestionnaires
            $recipients = User::where('is_admin', User::ROLE_CHAMBER_MANAGER)
                ->get()
                ->toArray();
        }

        return $recipients;
    }

    /**
     * Valide qu'il y a des destinataires
     */
    public function validateRecipients(string $recipientType, ?Chamber $chamber = null): bool
    {
        $recipients = $this->getRecipients($recipientType, $chamber);
        return count($recipients) > 0;
    }

    /**
     * Envoie une notification de bienvenue au gestionnaire
     */
    public function sendManagerWelcomeNotification(User $manager, Chamber $chamber = null): void
    {
        $subject = "Bienvenue en tant que gestionnaire";
        $message = "Vous avez été promu gestionnaire de chambre. " .
            ($chamber ? "Vous pouvez maintenant gérer la chambre: {$chamber->name}" : "");

        $this->sendBulkNotification('email', [$manager], [
            'subject' => $subject,
            'message' => $message,
        ]);
    }

    /**
     * Notifie les gestionnaires de la certification d'une chambre
     */
    public function notifyManagersOfCertification(Chamber $chamber): void
    {
        $managers = $chamber->members()
            ->wherePivot('role', 'manager')
            ->get();

        foreach ($managers as $manager) {
            $subject = "Chambre {$chamber->name} - Certification délivrée";
            $message = "Votre chambre a été agréée avec le numéro d'état: {$chamber->state_number}";

            $this->sendBulkNotification('email', [$manager], [
                'subject' => $subject,
                'message' => $message,
            ]);
        }
    }

    /**
     * Notifie les gestionnaires d'un changement de statut
     */
    public function notifyManagersOfStatusChange(Chamber $chamber, string $newStatus): void
    {
        $managers = $chamber->members()
            ->wherePivot('role', 'manager')
            ->get();

        foreach ($managers as $manager) {
            $subject = "Chambre {$chamber->name} - Changement de statut";
            $message = "Le statut de votre chambre a changé à: {$newStatus}";

            $this->sendBulkNotification('email', [$manager], [
                'subject' => $subject,
                'message' => $message,
            ]);
        }
    }

    /**
     * Archive ou enregistre une notification en masse
     */
    public function logBulkNotification(string $type, int $recipientCount, string $subject, string $status): void
    {
        // À implémenter avec une table audit_logs
        // Pour la phase 1, on peut skip cela
    }
}

