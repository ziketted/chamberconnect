<?php

namespace App\Http\Controllers;

use App\Models\Chamber;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\MembershipApproved;

class ChamberMemberController extends Controller
{
    public function create(Chamber $chamber)
    {
        return view('chambers.members.create', compact('chamber'));
    }

    public function store(Request $request, Chamber $chamber)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'role' => ['required', 'in:member,manager'],
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Utilisateur non trouvé avec cet email']);
        }

        // Vérifier si l'utilisateur est déjà membre
        $existingMember = $chamber->members()->where('user_id', $user->id)->first();
        if ($existingMember) {
            return back()->withErrors(['email' => 'Cet utilisateur est déjà membre de cette chambre']);
        }

        // Ajouter le membre avec le statut approprié
        $status = 'approved'; // Les membres ajoutés par un gestionnaire sont automatiquement approuvés

        $chamber->members()->attach($user->id, [
            'role' => $data['role'],
            'status' => $status
        ]);

        // Si le rôle est manager, mettre à jour le rôle global de l'utilisateur
        if ($data['role'] === 'manager') {
            $user->update(['is_admin' => User::ROLE_CHAMBER_MANAGER]);
        }

        return redirect()->route('chamber.show', $chamber)->with('success', 'Membre ajouté avec succès');
    }

    public function join(Request $request, Chamber $chamber)
    {
        $userId = $request->user()->id;
        $exists = $chamber->members()->where('user_id', $userId)->exists();

        if ($exists) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous êtes déjà membre de cette chambre ou avez déjà une demande en cours.'
                ]);
            }
            return back()->with('error', 'Vous êtes déjà membre de cette chambre ou avez déjà une demande en cours.');
        }

        $chamber->members()->attach($userId, ['role' => 'member', 'status' => 'pending']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Demande d\'adhésion envoyée avec succès !'
            ]);
        }

        return back()->with('status', 'Demande d\'adhésion envoyée');
    }

    public function approve(Request $request, Chamber $chamber, User $user)
    {
        // Only managers (middleware) or admins (via managesChamber check fail but admin can be included via policy; accept here through admin flag)
        if (!$request->user()->is_admin && !$request->user()->managesChamber($chamber)) {
            abort(403);
        }
        $chamber->members()->updateExistingPivot($user->id, ['status' => 'approved']);
        // Notification
        $user->notify(new MembershipApproved($chamber));
        return back()->with('status', 'Adhésion approuvée');
    }

    public function pending(Chamber $chamber)
    {
        $pending = $chamber->members()->wherePivot('status', 'pending')->get();
        return view('chambers.members.pending', compact('chamber', 'pending'));
    }

    /**
     * API pour rechercher des utilisateurs par email
     */
    public function searchUsers(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $users = User::where('email', 'LIKE', "%{$query}%")
            ->orWhere('name', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name', 'email'])
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'display' => $user->name . ' (' . $user->email . ')'
                ];
            });

        return response()->json($users);
    }
}
