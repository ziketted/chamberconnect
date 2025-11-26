<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chamber;
use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Affiche le tableau de bord SuperAdmin
     */
    public function dashboard()
    {
        // Statistiques générales
        $stats = [
            'total_chambers' => Chamber::count(),
            'pending_chambers' => Chamber::where('verified', false)->count(),
            'verified_chambers' => Chamber::where('verified', true)->count(),
            'certified_chambers' => Chamber::whereNotNull('state_number')->count(),
            'total_managers' => User::where('is_admin', User::ROLE_CHAMBER_MANAGER)->count(),
            'total_users' => User::where('is_admin', User::ROLE_USER)->count(),
        ];

        // Données pour le graphique de croissance (12 derniers mois)
        $monthlyGrowth = Chamber::selectRaw('COUNT(*) as count, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->where('created_at', '>=', \Carbon\Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->count];
            });

        // Remplir les mois manquants avec 0
        $growthData = [];
        $labels = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $labels[] = $date->translatedFormat('M Y');
            $growthData[] = $monthlyGrowth[$monthKey] ?? 0;
        }

        // Top 5 des chambres par nombre de membres
        $topChambers = Chamber::withCount('members')
            ->orderByDesc('members_count')
            ->take(5)
            ->get(['name', 'members_count']);

        return view('admin.super-admin.dashboard', compact('stats', 'growthData', 'labels', 'topChambers'));
    }

    /**
     * Affiche la liste des chambres (ancienne route)
     */
    public function chambers()
    {
        return redirect()->route('super-admin.chambers.index');
    }

    /**
     * Affiche la liste des utilisateurs (ancienne route)
     */
    public function users()
    {
        return redirect()->route('super-admin.managers.index');
    }

    /**
     * Vérifie une chambre
     */
    public function verifyChamber(Chamber $chamber)
    {
        $chamber->update(['verified' => true]);
        return redirect()->back()->with('success', "Chambre '{$chamber->name}' vérifiée!");
    }

    /**
     * Annule la vérification d'une chambre
     */
    public function unverifyChamber(Chamber $chamber)
    {
        $chamber->update(['verified' => false]);
        return redirect()->back()->with('success', "Chambre '{$chamber->name}' non vérifiée!");
    }

    /**
     * Suspend une chambre
     */
    public function suspendChamber(Chamber $chamber)
    {
        $chamber->update(['status' => 'suspended']);
        return redirect()->back()->with('success', "Chambre '{$chamber->name}' suspendue!");
    }

    /**
     * Certifie une chambre
     */
    public function certifyChamber(Request $request, Chamber $chamber)
    {
        $validated = $request->validate([
            'state_number' => 'required|string|unique:chambers,state_number,' . $chamber->id,
            'certification_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $chamber->update([
            'state_number' => $validated['state_number'],
            'certification_date' => $validated['certification_date'],
            'certification_notes' => $validated['notes'],
            'verified' => true,
        ]);

        return redirect()->back()->with('success', "Chambre '{$chamber->name}' certifiée!");
    }

    /**
     * Annule la certification d'une chambre
     */
    public function uncertifyChamber(Chamber $chamber)
    {
        $chamber->update([
            'state_number' => null,
            'certification_date' => null,
            'certification_notes' => null,
        ]);

        return redirect()->back()->with('success', "Certification de '{$chamber->name}' annulée!");
    }

    /**
     * Gère les détails d'une chambre
     */
    public function manageChamber(Chamber $chamber)
    {
        // TODO: Implémenter la page de gestion détaillée
        return view('admin.super-admin.chambers.manage', compact('chamber'));
    }

    /**
     * Retire un membre d'une chambre
     */
    public function removeMember(Request $request, Chamber $chamber)
    {
        $userId = $request->input('user_id');
        $chamber->members()->detach($userId);

        return redirect()->back()->with('success', 'Membre retiré de la chambre');
    }

    /**
     * Affiche le formulaire d'assignation d'un gestionnaire
     */
    public function showAssignManager(Chamber $chamber)
    {
        $availableUsers = User::where('is_admin', '!=', User::ROLE_SUPER_ADMIN)->get();
        return view('admin.super-admin.chambers.assign-manager', compact('chamber', 'availableUsers'));
    }

    /**
     * Assigne un gestionnaire à une chambre
     */
    public function assignManager(Request $request, Chamber $chamber)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($validated['user_id']);
        
        // Ajouter l'utilisateur à la chambre en tant que gestionnaire
        if (!$chamber->members->contains($user->id)) {
            $chamber->members()->attach($user->id, ['role' => 'manager']);
        } else {
            $chamber->members()->updateExistingPivot($user->id, ['role' => 'manager']);
        }

        // Mettre à jour le rôle de l'utilisateur si nécessaire
        if ($user->is_admin !== User::ROLE_CHAMBER_MANAGER) {
            $user->update(['is_admin' => User::ROLE_CHAMBER_MANAGER]);
        }

        return redirect()->back()->with('success', "'{$user->name}' est maintenant gestionnaire de '{$chamber->name}'");
    }

    /**
     * Retire un gestionnaire d'une chambre
     */
    public function removeManager(Request $request, Chamber $chamber)
    {
        $userId = $request->input('user_id');
        $chamber->members()->updateExistingPivot($userId, ['role' => 'member']);

        return redirect()->back()->with('success', 'Gestionnaire retiré');
    }

    /**
     * Promeut un utilisateur en gestionnaire
     */
    public function promoteToManager(User $user)
    {
        $user->update(['is_admin' => User::ROLE_CHAMBER_MANAGER]);
        return redirect()->back()->with('success', "'{$user->name}' a été promu gestionnaire");
    }

    /**
     * Rétrograde un gestionnaire en utilisateur normal
     */
    public function demoteToUser(User $user)
    {
        $user->update(['is_admin' => User::ROLE_USER]);
        $user->chambers()->detach();

        return redirect()->back()->with('success', "'{$user->name}' a été rétrogradé");
    }

    /**
     * Affiche les demandes de création de chambres en attente
     */
    public function pendingRequests()
    {
        $pendingChambers = Chamber::where('verified', false)->paginate(15);
        return view('admin.super-admin.pending-requests', compact('pendingChambers'));
    }

    /**
     * Approuve une demande de création de chambre
     */
    public function approveChamberRequest(Chamber $chamber)
    {
        $chamber->update(['verified' => true]);
        return redirect()->back()->with('success', "Demande approuvée pour '{$chamber->name}'");
    }

    /**
     * Rejette une demande de création de chambre
     */
    public function rejectChamberRequest(Request $request, Chamber $chamber)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);

        $chamber->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->back()->with('success', "Demande rejetée pour '{$chamber->name}'");
    }
}
