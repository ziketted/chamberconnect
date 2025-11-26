<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Chamber;
use Illuminate\Http\Request;

class SuperAdminUserController extends Controller
{
    /**
     * Affiche la liste des gestionnaires et utilisateurs
     */
    public function index(Request $request)
    {
        // Construire la requête de base pour les gestionnaires
        $managersQuery = User::where('is_admin', User::ROLE_CHAMBER_MANAGER)
            ->with(['chambers' => function ($query) {
                $query->wherePivot('role', 'manager');
            }]);

        // Appliquer les filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $managersQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtre par statut de vérification email
        if ($request->filled('email_verified')) {
            if ($request->email_verified === 'verified') {
                $managersQuery->whereNotNull('email_verified_at');
            } elseif ($request->email_verified === 'unverified') {
                $managersQuery->whereNull('email_verified_at');
            }
        }

        // Filtre par nombre de chambres gérées
        if ($request->filled('chambers_count')) {
            $chambersCount = $request->chambers_count;
            if ($chambersCount === 'none') {
                $managersQuery->whereDoesntHave('chambers', function ($query) {
                    $query->where('chamber_user.role', 'manager');
                });
            } elseif ($chambersCount === 'one') {
                $managersQuery->whereHas('chambers', function ($query) {
                    $query->where('chamber_user.role', 'manager');
                }, '=', 1);
            } elseif ($chambersCount === 'multiple') {
                $managersQuery->whereHas('chambers', function ($query) {
                    $query->where('chamber_user.role', 'manager');
                }, '>', 1);
            }
        }

        // Tri
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if (in_array($sortBy, ['name', 'email', 'created_at'])) {
            $managersQuery->orderBy($sortBy, $sortOrder);
        } else {
            $managersQuery->orderBy('name', 'asc');
        }

        $managers = $managersQuery->paginate(15)->withQueryString();

        // Statistiques
        $stats = [
            'total_managers' => User::where('is_admin', User::ROLE_CHAMBER_MANAGER)->count(),
            'total_users' => User::where('is_admin', User::ROLE_USER)->count(),
            'total_super_admins' => User::where('is_admin', User::ROLE_SUPER_ADMIN)->count(),
            'verified_managers' => User::where('is_admin', User::ROLE_CHAMBER_MANAGER)
                ->whereNotNull('email_verified_at')->count(),
            'unverified_managers' => User::where('is_admin', User::ROLE_CHAMBER_MANAGER)
                ->whereNull('email_verified_at')->count(),
        ];

        // Chambres disponibles pour la promotion
        $availableChambers = Chamber::where('verified', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.super-admin.managers.index', compact(
            'managers', 
            'stats', 
            'availableChambers'
        ));
    }

    /**
     * Promeut un utilisateur en gestionnaire
     */
    public function promote(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'chamber_id' => 'required|exists:chambers,id',
        ]);

        $user = User::findOrFail($validated['user_id']);
        $chamber = Chamber::findOrFail($validated['chamber_id']);

        // Promouvoir l'utilisateur
        $user->update(['is_admin' => User::ROLE_CHAMBER_MANAGER]);

        // Ajouter à la chambre avec le rôle de gestionnaire
        if (!$user->chambers->contains($chamber->id)) {
            $user->chambers()->attach($chamber->id, ['role' => 'manager']);
        } else {
            $user->chambers()->updateExistingPivot($chamber->id, ['role' => 'manager']);
        }

        // TODO: Envoyer email de notification

        return redirect()->route('super-admin.managers.index')
            ->with('success', "'{$user->name}' a été promu gestionnaire de '{$chamber->name}'");
    }

    /**
     * Récupère les détails d'un utilisateur pour le modal
     */
    public function details(User $user)
    {
        // Charger les relations nécessaires
        $user->load(['chambers' => function ($query) {
            $query->wherePivot('role', 'manager');
        }]);

        // Calculer les statistiques
        $managedChambersCount = $user->chambers->count();
        $totalMembers = $user->chambers->sum(function ($chamber) {
            return $chamber->members()->count();
        });

        // Préparer les données pour le JSON
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
            'last_login' => $user->last_login_at ?? null,
            'role_text' => $user->getRoleText(),
            'managed_chambers' => $user->chambers->map(function ($chamber) {
                return [
                    'id' => $chamber->id,
                    'name' => $chamber->name,
                    'slug' => $chamber->slug,
                    'verified' => $chamber->verified,
                    'members_count' => $chamber->members()->count(),
                ];
            }),
            'managed_chambers_count' => $managedChambersCount,
            'total_members' => $totalMembers,
        ];

        return response()->json([
            'success' => true,
            'user' => $userData
        ]);
    }

    /**
     * Rétrograde un gestionnaire en utilisateur normal
     */
    public function demote(Request $request, $user)
    {
        $userModel = User::findOrFail($user);
        
        $userModel->update(['is_admin' => User::ROLE_USER]);

        // Retirer de toutes les chambres
        $userModel->chambers()->detach();

        return redirect()->route('super-admin.managers.index')
            ->with('success', "'{$userModel->name}' a été rétrogradé en utilisateur normal");
    }
}
