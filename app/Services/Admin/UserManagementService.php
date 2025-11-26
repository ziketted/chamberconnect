<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\Chamber;
use App\Mail\ManagerPromotedMail;
use Illuminate\Support\Facades\Mail;

class UserManagementService
{
    /**
     * Promeut un utilisateur en gestionnaire de chambre
     */
    public function promoteToManager(User $user, Chamber $chamber = null): User
    {
        // Vérifier que l'utilisateur est un utilisateur normal
        if ($user->is_admin !== User::ROLE_USER) {
            throw new \Exception("L'utilisateur ne peut pas être promu (rôle invalide).");
        }

        // Mettre à jour le rôle
        $user->update(['is_admin' => User::ROLE_CHAMBER_MANAGER]);

        // Si une chambre est spécifiée, attacher l'utilisateur comme manager
        if ($chamber) {
            if (!$chamber->members()->where('user_id', $user->id)->exists()) {
                $chamber->members()->attach($user->id, [
                    'role' => 'manager',
                    'status' => 'approved',
                ]);
            }
        }

        // Envoyer un email de notification
        Mail::to($user->email)->send(new ManagerPromotedMail($user, $chamber));

        return $user;
    }

    /**
     * Rétrograde un gestionnaire en utilisateur normal
     */
    public function demoteToUser(User $user): User
    {
        // Vérifier que l'utilisateur est un gestionnaire
        if ($user->is_admin !== User::ROLE_CHAMBER_MANAGER) {
            throw new \Exception("L'utilisateur n'est pas un gestionnaire.");
        }

        // Vérifier qu'il n'a pas de chambres à gérer
        $managedChambers = $user->chambers()
            ->wherePivot('role', 'manager')
            ->count();

        if ($managedChambers > 0) {
            throw new \Exception("L'utilisateur gère encore {$managedChambers} chambre(s). Veuillez réassigner les gestionnaires.");
        }

        // Mettre à jour le rôle
        $user->update(['is_admin' => User::ROLE_USER]);

        // Détacher l'utilisateur de toutes les chambres
        $user->chambers()->detach();

        return $user;
    }

    /**
     * Récupère tous les gestionnaires
     */
    public function getAllManagers()
    {
        return User::where('is_admin', User::ROLE_CHAMBER_MANAGER)
            ->with(['chambers' => function ($query) {
                $query->wherePivot('role', 'manager');
            }])
            ->withCount(['chambers' => function ($query) {
                $query->wherePivot('role', 'manager');
            }])
            ->orderBy('name', 'asc')
            ->paginate(15);
    }

    /**
     * Récupère tous les utilisateurs normaux
     */
    public function getAllRegularUsers()
    {
        return User::where('is_admin', User::ROLE_USER)
            ->orderBy('name', 'asc')
            ->paginate(15);
    }

    /**
     * Recherche des utilisateurs
     */
    public function searchUsers(string $query, $role = null)
    {
        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%");

        if ($role === 'manager') {
            $users->where('is_admin', User::ROLE_CHAMBER_MANAGER);
        } elseif ($role === 'user') {
            $users->where('is_admin', User::ROLE_USER);
        }

        return $users->with(['chambers' => function ($query) {
            $query->wherePivot('role', 'manager');
        }])->paginate(15);
    }

    /**
     * Récupère les utilisateurs non-manager pour promouvoir
     */
    public function getPromotableChamberManagers(Chamber $chamber)
    {
        // Récupère les utilisateurs non-managers qui ne gèrent pas encore cette chambre
        return User::where('is_admin', User::ROLE_USER)
            ->whereNotIn('id', function ($query) use ($chamber) {
                $query->select('user_id')
                    ->from('chamber_user')
                    ->where('chamber_id', $chamber->id);
            })
            ->orderBy('name', 'asc')
            ->limit(20)
            ->get();
    }

    /**
     * Obtient les statistiques des utilisateurs
     */
    public function getUserStats(): array
    {
        return [
            'total' => User::count(),
            'managers' => User::where('is_admin', User::ROLE_CHAMBER_MANAGER)->count(),
            'regular_users' => User::where('is_admin', User::ROLE_USER)->count(),
            'super_admins' => User::where('is_admin', User::ROLE_SUPER_ADMIN)->count(),
        ];
    }

    /**
     * Obtient les détails d'un gestionnaire avec ses chambres
     */
    public function getManagerDetails(User $manager)
    {
        if ($manager->is_admin !== User::ROLE_CHAMBER_MANAGER) {
            throw new \Exception("L'utilisateur n'est pas un gestionnaire.");
        }

        return [
            'user' => $manager,
            'chambers' => $manager->chambers()
                ->wherePivot('role', 'manager')
                ->get(),
            'total_members' => $manager->chambers()
                ->wherePivot('role', 'manager')
                ->withCount('members')
                ->get()
                ->sum('members_count'),
        ];
    }

    /**
     * Valide si un utilisateur peut être promu
     */
    public function canBePromoted(User $user): bool
    {
        return $user->is_admin === User::ROLE_USER && $user->email_verified_at !== null;
    }

    /**
     * Valide si un utilisateur peut être rétrogradé
     */
    public function canBeDemoted(User $user): bool
    {
        if ($user->is_admin !== User::ROLE_CHAMBER_MANAGER) {
            return false;
        }

        $managedChambers = $user->chambers()
            ->wherePivot('role', 'manager')
            ->count();

        return $managedChambers === 0;
    }
}

