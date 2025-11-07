<?php

namespace App\Http\Controllers;

use App\Models\Chamber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChamberManagerController extends Controller
{
    /**
     * Tableau de bord du gestionnaire de chambre
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Récupérer les chambres gérées par l'utilisateur
        $managedChambers = $user->chambers()
            ->wherePivot('role', 'manager')
            ->withCount(['members', 'events', 'posts'])
            ->get();

        // Statistiques globales
        $stats = [
            'total_chambers' => $managedChambers->count(),
            'total_members' => $managedChambers->sum('members_count'),
            'total_events' => $managedChambers->sum('events_count'),
            'total_posts' => $managedChambers->sum('posts_count'),
        ];

        // Membres en attente d'approbation
        $pendingMembers = collect();
        foreach ($managedChambers as $chamber) {
            $pending = $chamber->members()
                ->wherePivot('status', 'pending')
                ->get()
                ->map(function ($member) use ($chamber) {
                    $member->chamber_name = $chamber->name;
                    $member->chamber_slug = $chamber->slug;
                    return $member;
                });
            $pendingMembers = $pendingMembers->merge($pending);
        }

        return view('chamber-manager.dashboard', compact('managedChambers', 'stats', 'pendingMembers'));
    }

    /**
     * Gestion des membres d'une chambre spécifique
     */
    public function manageMembers(Chamber $chamber)
    {
        // Vérifier que l'utilisateur gère cette chambre
        if (!Auth::user()->managesChamber($chamber)) {
            abort(403, 'Vous n\'êtes pas autorisé à gérer cette chambre.');
        }

        $members = $chamber->members()
            ->withPivot(['role', 'status', 'created_at'])
            ->orderBy('pivot_created_at', 'desc')
            ->get();

        $pendingMembers = $chamber->members()
            ->wherePivot('status', 'pending')
            ->withPivot(['role', 'status', 'created_at'])
            ->get();

        return view('chamber-manager.members', compact('chamber', 'members', 'pendingMembers'));
    }

    /**
     * Approuver un membre
     */
    public function approveMember(Request $request, Chamber $chamber, User $user)
    {
        if (!Auth::user()->managesChamber($chamber)) {
            abort(403);
        }

        $chamber->members()->updateExistingPivot($user->id, ['status' => 'approved']);

        return redirect()->back()->with('success', 'Membre approuvé avec succès.');
    }

    /**
     * Rejeter un membre
     */
    public function rejectMember(Request $request, Chamber $chamber, User $user)
    {
        if (!Auth::user()->managesChamber($chamber)) {
            abort(403);
        }

        $chamber->members()->detach($user->id);

        return redirect()->back()->with('success', 'Demande d\'adhésion rejetée.');
    }

    /**
     * Retirer un membre
     */
    public function removeMember(Request $request, Chamber $chamber, User $user)
    {
        if (!Auth::user()->managesChamber($chamber)) {
            abort(403);
        }

        $chamber->members()->detach($user->id);

        return redirect()->back()->with('success', 'Membre retiré de la chambre.');
    }

    /**
     * Changer le rôle d'un membre
     */
    public function changeRole(Request $request, Chamber $chamber, User $user)
    {
        if (!Auth::user()->managesChamber($chamber)) {
            abort(403);
        }

        $request->validate([
            'role' => 'required|in:member,manager'
        ]);

        $chamber->members()->updateExistingPivot($user->id, ['role' => $request->role]);

        // Si promu manager, mettre à jour le rôle global
        if ($request->role === 'manager') {
            $user->update(['is_admin' => User::ROLE_CHAMBER_MANAGER]);
        }

        return redirect()->back()->with('success', 'Rôle mis à jour avec succès.');
    }
}