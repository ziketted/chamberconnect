<?php

namespace App\Http\Controllers;

use App\Models\Chamber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChamberManagerController extends Controller
{
    /**
     * Section "Gestion des chambres" - Point d'entrée principal
     * Inspiré de Facebook Pages
     */
    public function index()
    {
        $user = Auth::user();

        // Récupérer les chambres gérées par l'utilisateur
        $managedChambers = $user->chambers()
            ->wherePivot('role', 'manager')
            ->withCount(['members', 'events'])
            ->with(['events' => function ($query) {
                $query->where('date', '>=', now())->orderBy('date', 'asc')->limit(3);
            }])
            ->get()
            ->map(function ($chamber) {
                // Calculer les statistiques pour chaque chambre
                $pendingMembersCount = $chamber->members()->wherePivot('status', 'pending')->count();
                $upcomingEventsCount = $chamber->events()->where('date', '>=', now())->count();

                return [
                    'id' => $chamber->id,
                    'name' => $chamber->name,
                    'slug' => $chamber->slug,
                    'logo_path' => $chamber->logo_path,
                    'cover_image_path' => $chamber->cover_image_path,
                    'description' => $chamber->description,
                    'location' => $chamber->location,
                    'members_count' => $chamber->members_count,
                    'events_count' => $chamber->events_count,
                    'pending_members_count' => $pendingMembersCount,
                    'upcoming_events_count' => $upcomingEventsCount,
                    'recent_events' => $chamber->events,
                    'created_at' => $chamber->created_at,
                ];
            });

        // Statistiques globales
        $globalStats = [
            'total_chambers' => $managedChambers->count(),
            'total_members' => $managedChambers->sum('members_count'),
            'total_pending' => $managedChambers->sum('pending_members_count'),
            'total_upcoming_events' => $managedChambers->sum('upcoming_events_count'),
        ];

        return view('chamber-manager.index', compact('managedChambers', 'globalStats'));
    }

    /**
     * Tableau de bord analytique pour une chambre spécifique
     */
    public function dashboard(Chamber $chamber)
    {
        // Vérifier que l'utilisateur gère cette chambre
        if (!Auth::user()->managesChamber($chamber)) {
            abort(403, 'Vous n\'êtes pas autorisé à gérer cette chambre.');
        }

        // 🧱 Zone de synthèse (cartes principales KPI)
        $totalMembers = $chamber->members()->wherePivot('status', 'approved')->count();
        $pendingRequests = $chamber->members()->wherePivot('status', 'pending')->count();
        $upcomingEvents = $chamber->events()->where('date', '>=', now())->count();

        // Calculer le taux de participation moyen
        $eventsWithParticipants = $chamber->events()
            ->withCount('participants')
            ->where('date', '<', now())
            ->get();
        $averageParticipation = $eventsWithParticipants->count() > 0
            ? round($eventsWithParticipants->avg('participants_count'), 1)
            : 0;

        $kpiCards = [
            'total_members' => $totalMembers,
            'pending_requests' => $pendingRequests,
            'upcoming_events' => $upcomingEvents,
            'average_participation' => $averageParticipation
        ];

        // 📈 Données pour les graphiques

        // 1. Histogramme – Évolution des membres (12 derniers mois)
        $memberEvolution = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = $chamber->members()
                ->wherePivot('status', 'approved')
                ->wherePivot('created_at', '<=', $date->endOfMonth())
                ->count();
            $memberEvolution[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        // 2. Pie Chart – Répartition des rôles
        $managersCount = $chamber->members()->wherePivot('role', 'manager')->count();
        $membersCount = $chamber->members()->wherePivot('role', 'member')->wherePivot('status', 'approved')->count();
        $pendingCount = $chamber->members()->wherePivot('status', 'pending')->count();

        $roleDistribution = [
            ['label' => 'Gestionnaires', 'value' => $managersCount, 'color' => '#3B82F6'],
            ['label' => 'Membres', 'value' => $membersCount, 'color' => '#10B981'],
            ['label' => 'En attente', 'value' => $pendingCount, 'color' => '#F59E0B']
        ];

        // 3. Line Chart – Taux de participation aux événements (6 derniers événements)
        $participationRates = $chamber->events()
            ->withCount('participants')
            ->where('date', '<', now())
            ->orderBy('date', 'desc')
            ->limit(6)
            ->get()
            ->reverse()
            ->map(function ($event) {
                $participationRate = $event->max_participants > 0
                    ? round(($event->participants_count / $event->max_participants) * 100, 1)
                    : 0;
                return [
                    'event' => substr($event->title, 0, 20) . '...',
                    'date' => $event->date->format('d/m'),
                    'rate' => $participationRate
                ];
            });

        // 4. Bar Chart – Répartition géographique (approx. par nationalité)
        // Utiliser une requête de base pour éviter la sélection automatique des colonnes pivot
        $geographicDistribution = DB::table('users')
            ->join('chamber_user', 'users.id', '=', 'chamber_user.user_id')
            ->where('chamber_user.chamber_id', $chamber->id)
            ->where('chamber_user.status', 'approved')
            ->selectRaw('COALESCE(users.nationality, "Non spécifié") as city, COUNT(*) as count')
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->map(function ($row) {
                return [
                    'city' => $row->city,
                    'count' => (int) $row->count,
                ];
            });

        // 🧮 Tableau analytique détaillé des membres
        // Évite withCount + wherePivot (source d'erreur SQL ici) et calcule par membre
        $approvedMembers = $chamber->members()
            ->wherePivot('status', 'approved')
            ->withPivot(['role', 'status', 'created_at'])
            ->orderBy('pivot_created_at', 'desc')
            ->get();

        $detailedMembers = $approvedMembers->map(function ($member) {
            $eventsParticipated = $member->events()->wherePivot('status', 'confirmed')->count();
            return [
                'id' => $member->id,
                'name' => $member->name,
                'email' => $member->email,
                'role' => $member->pivot->role,
                'status' => $member->pivot->status,
                'joined_at' => $member->pivot->created_at,
                'events_participated' => $eventsParticipated,
                'is_active' => $member->pivot->created_at > now()->subMonths(3)
            ];
        });

        // Membres en attente d'approbation
        $pendingMembers = $chamber->members()
            ->wherePivot('status', 'pending')
            ->withPivot(['created_at'])
            ->orderBy('pivot_created_at', 'desc')
            ->get();

        // Événements récents et à venir
        $recentEvents = $chamber->events()
            ->withCount('participants')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        return view('chamber-manager.dashboard', compact(
            'chamber',
            'kpiCards',
            'memberEvolution',
            'roleDistribution',
            'participationRates',
            'geographicDistribution',
            'detailedMembers',
            'pendingMembers',
            'recentEvents'
        ));
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

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rôle mis à jour avec succès.',
                'role' => $request->role
            ]);
        }
        return redirect()->back()->with('success', 'Rôle mis à jour avec succès.');
    }

    /**
     * Détails d'un membre (AJAX)
     */
    public function memberDetails(Chamber $chamber, User $user)
    {
        if (!Auth::user()->managesChamber($chamber)) {
            abort(403);
        }
        $membership = $chamber->members()->where('user_id', $user->id)->firstOrFail();
        $eventsConfirmed = $user->events()->wherePivot('status', 'confirmed')->count();
        $eventsReserved = $user->events()->wherePivot('status', 'reserved')->count();

        return response()->json([
            'success' => true,
            'member' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'company' => $user->company,
                'nationality' => $user->nationality,
                'role' => $membership->pivot->role,
                'status' => $membership->pivot->status,
                'joined_at' => optional($membership->pivot->created_at)?->toDateString(),
                'events_confirmed' => $eventsConfirmed,
                'events_reserved' => $eventsReserved,
            ]
        ]);
    }
}
