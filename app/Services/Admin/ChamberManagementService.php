<?php

namespace App\Services\Admin;

use App\Models\Chamber;
use App\Models\User;
use App\Mail\ChamberCertifiedMail;
use App\Mail\ChamberApprovedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ChamberManagementService
{
    /**
     * Certifie une chambre (attribue un numéro d'état)
     */
    public function certifyChamber(Chamber $chamber, array $data): Chamber
    {
        $chamber->update([
            'state_number' => $data['state_number'],
            'certification_date' => $data['certification_date'] ?? now()->toDateString(),
            'certification_notes' => $data['certification_notes'] ?? null,
            'verified' => true,
        ]);

        // Envoyer un email au(x) gestionnaire(s)
        $managers = $chamber->members()
            ->wherePivot('role', 'manager')
            ->get();

        foreach ($managers as $manager) {
            Mail::to($manager->email)->send(new ChamberCertifiedMail($chamber, $manager));
        }

        return $chamber;
    }

    /**
     * Décertifie une chambre
     */
    public function uncertifyChamber(Chamber $chamber): Chamber
    {
        $chamber->update([
            'state_number' => null,
            'certification_date' => null,
            'certification_notes' => null,
            'verified' => false,
        ]);

        return $chamber;
    }

    /**
     * Approuve une demande de création de chambre
     */
    public function approveChamberRequest(Chamber $chamber, User $manager, array $data): Chamber
    {
        // Mettre à jour la chambre
        $chamber->update([
            'verified' => true,
            'state_number' => $data['state_number'] ?? null,
            'certification_date' => $data['certification_date'] ?? now()->toDateString(),
        ]);

        // Attacher le gestionnaire s'il n'est pas déjà attaché
        if (!$chamber->members()->where('user_id', $manager->id)->exists()) {
            $chamber->members()->attach($manager->id, [
                'role' => 'manager',
                'status' => 'approved',
            ]);
        } else {
            $chamber->members()->updateExistingPivot($manager->id, [
                'role' => 'manager',
                'status' => 'approved',
            ]);
        }

        // Envoyer l'email au gestionnaire
        Mail::to($manager->email)->send(new ChamberApprovedMail($chamber, $manager));

        // Envoyer un email au créateur de la demande (si disponible)
        $creator = $chamber->members()
            ->wherePivot('role', '!=', 'manager')
            ->first();

        if ($creator) {
            Mail::to($creator->email)->send(new ChamberApprovedMail($chamber, $creator));
        }

        return $chamber;
    }

    /**
     * Rejette une demande de création de chambre
     */
    public function rejectChamberRequest(Chamber $chamber, string $reason = ''): void
    {
        // Soft delete ou marquer comme rejetée
        // Pour l'instant, on va juste supprimer la chambre
        $chamber->delete();

        // Optionnel: Envoyer un email de rejet
        // Mail::to($creator)->send(new ChamberRejectedMail($chamber, $reason));
    }

    /**
     * Supprime une chambre (soft delete)
     */
    public function deleteChamber(Chamber $chamber): void
    {
        $chamber->delete();
    }

    /**
     * Récupère toutes les chambres en attente de certification
     */
    public function getPendingChambers()
    {
        return Chamber::where('verified', false)
            ->with(['members' => function ($query) {
                $query->wherePivot('role', 'manager');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    /**
     * Récupère toutes les chambres certifiées
     */
    public function getCertifiedChambers()
    {
        return Chamber::whereNotNull('state_number')
            ->orderBy('certification_date', 'desc')
            ->paginate(15);
    }

    /**
     * Récupère toutes les chambres vérifiées
     */
    public function getVerifiedChambers()
    {
        return Chamber::where('verified', true)
            ->orderBy('name', 'asc')
            ->paginate(15);
    }

    /**
     * Recherche des chambres
     */
    public function searchChambers(string $query, $status = null)
    {
        $chambers = Chamber::query()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('location', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%");

        if ($status === 'verified') {
            $chambers->where('verified', true);
        } elseif ($status === 'pending') {
            $chambers->where('verified', false);
        } elseif ($status === 'certified') {
            $chambers->whereNotNull('state_number');
        }

        return $chambers->with(['members' => function ($query) {
            $query->withPivot('role');
        }])->paginate(15);
    }

    /**
     * Obtient les statistiques des chambres
     */
    public function getChamberStats(): array
    {
        return [
            'total' => Chamber::count(),
            'verified' => Chamber::where('verified', true)->count(),
            'pending' => Chamber::where('verified', false)->count(),
            'certified' => Chamber::whereNotNull('state_number')->count(),
        ];
    }

    /**
     * Valide l'unicité du numéro d'état
     */
    public function isStateNumberUnique(string $stateNumber, ?Chamber $chamber = null): bool
    {
        $query = Chamber::where('state_number', $stateNumber);

        if ($chamber) {
            $query->where('id', '!=', $chamber->id);
        }

        return $query->count() === 0;
    }
}

