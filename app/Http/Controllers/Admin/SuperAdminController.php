<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chamber;
use App\Models\User;
use App\Mail\ChamberApprovedMail;
use App\Mail\ChamberRejectedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SuperAdminController extends Controller
{
    /**
     * Affiche le tableau de bord du super admin
     */
    public function dashboard()
    {
        $stats = [
            'total_chambers' => Chamber::count(),
            'verified_chambers' => Chamber::where('verified', true)->count(),
            'pending_chambers' => Chamber::where('verified', false)->count(),
            'total_users' => User::count(),
            'chamber_managers' => User::where('is_admin', User::ROLE_CHAMBER_MANAGER)->count(),
            'regular_users' => User::where('is_admin', User::ROLE_USER)->count(),
        ];

        return view('admin.super-admin.dashboard', compact('stats'));
    }

    /**
     * Liste toutes les chambres pour gestion
     */
    public function chambers()
    {
        $chambers = Chamber::with(['members' => function($query) {
            $query->withPivot('role', 'status', 'created_at');
        }])->withCount('members')->paginate(15);

        return view('admin.super-admin.chambers', compact('chambers'));
    }

    /**
     * Certifie une chambre
     */
    public function verifyChamber(Chamber $chamber)
    {
        $chamber->update(['verified' => true]);

        return redirect()->back()->with('success', 'Chambre certifiée avec succès.');
    }

    /**
     * Retire la certification d'une chambre
     */
    public function unverifyChamber(Chamber $chamber)
    {
        $chamber->update(['verified' => false]);

        return redirect()->back()->with('success', 'Certification retirée avec succès.');
    }

    /**
     * Suspend une chambre
     */
    public function suspendChamber(Chamber $chamber)
    {
        // Ajouter un champ 'status' à la table chambers si nécessaire
        // Pour l'instant, on peut utiliser verified = false comme suspension
        $chamber->update(['verified' => false]);

        return redirect()->back()->with('success', 'Chambre suspendue avec succès.');
    }

    /**
     * Affiche la page d'assignation de gestionnaire
     */
    public function showAssignManager(Chamber $chamber)
    {
        return view('admin.super-admin.assign-manager', compact('chamber'));
    }

    /**
     * Assigne un gestionnaire à une chambre
     */
    public function assignManager(Request $request, Chamber $chamber)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        // Mettre à jour le rôle de l'utilisateur
        $user->update(['is_admin' => User::ROLE_CHAMBER_MANAGER]);

        // Attacher l'utilisateur à la chambre comme manager
        $chamber->members()->syncWithoutDetaching([
            $user->id => ['role' => 'manager', 'status' => 'approved']
        ]);

        return redirect()->back()->with('success', 'Gestionnaire assigné avec succès.');
    }

    /**
     * Retire un gestionnaire d'une chambre
     */
    public function removeManager(Request $request, Chamber $chamber)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        // Retirer l'utilisateur de la chambre
        $chamber->members()->detach($user->id);

        // Vérifier si l'utilisateur gère d'autres chambres
        $otherChambers = $user->chambers()->wherePivot('role', 'manager')->count();
        
        if ($otherChambers === 0) {
            // Si plus de chambres à gérer, redevenir utilisateur normal
            $user->update(['is_admin' => User::ROLE_USER]);
        }

        return redirect()->back()->with('success', 'Gestionnaire retiré avec succès.');
    }

    /**
     * Liste des utilisateurs pour gestion
     */
    public function users()
    {
        $users = User::with('chambers')->paginate(20);

        return view('admin.super-admin.users', compact('users'));
    }

    /**
     * Promouvoir un utilisateur en gestionnaire de chambre
     */
    public function promoteToManager(User $user)
    {
        $user->update(['is_admin' => User::ROLE_CHAMBER_MANAGER]);

        return redirect()->back()->with('success', 'Utilisateur promu gestionnaire de chambre.');
    }

    /**
     * Rétrograder un gestionnaire en utilisateur normal
     */
    public function demoteToUser(User $user)
    {
        // Retirer de toutes les chambres gérées
        DB::table('chamber_user')
            ->where('user_id', $user->id)
            ->where('role', 'manager')
            ->delete();

        $user->update(['is_admin' => User::ROLE_USER]);

        return redirect()->back()->with('success', 'Gestionnaire rétrogradé en utilisateur normal.');
    }

    /**
     * Certifie une chambre avec attribution d'un numéro d'état
     */
    public function certifyChamber(Request $request, Chamber $chamber)
    {
        $request->validate([
            'state_number' => 'required|string|max:50|unique:chambers,state_number,' . $chamber->id,
            'certification_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $chamber->update([
            'verified' => true,
            'state_number' => $request->state_number,
            'certification_date' => $request->certification_date,
            'certification_notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Chambre certifiée avec succès. Numéro d\'état: ' . $request->state_number);
    }

    /**
     * Approuve une demande de création de chambre
     */
    public function approveChamberRequest(Request $request, Chamber $chamber)
    {
        $request->validate([
            'state_number' => 'nullable|string|max:50|unique:chambers,state_number,' . $chamber->id,
            'notes' => 'nullable|string|max:1000',
        ]);

        // Générer un numéro d'état automatique si non fourni
        $stateNumber = $request->state_number;
        if (!$stateNumber) {
            $year = date('Y');
            $lastNumber = Chamber::whereNotNull('state_number')
                ->where('state_number', 'like', "CHMBR-{$year}-%")
                ->count();
            $stateNumber = sprintf('CHMBR-%s-%04d', $year, $lastNumber + 1);
        }

        // Mettre à jour la chambre
        $chamber->update([
            'verified' => true,
            'state_number' => $stateNumber,
            'certification_date' => now(),
            'certification_notes' => $request->notes,
        ]);

        // Promouvoir le demandeur en gestionnaire de chambre
        $applicant = $chamber->members()->wherePivot('role', 'applicant')->first();
        if ($applicant) {
            // Mettre à jour le rôle de l'utilisateur
            $applicant->update(['is_admin' => User::ROLE_CHAMBER_MANAGER]);
            
            // Mettre à jour la relation dans la table pivot
            $chamber->members()->updateExistingPivot($applicant->id, [
                'role' => 'manager',
                'status' => 'approved'
            ]);

            // Envoyer un email de validation
            try {
                Mail::to($applicant->email)->send(new ChamberApprovedMail($chamber, $stateNumber));
            } catch (\Exception $e) {
                \Log::error('Erreur lors de l\'envoi de l\'email d\'approbation: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Demande approuvée avec succès. Numéro d\'état: ' . $stateNumber);
    }

    /**
     * Rejette une demande de création de chambre
     */
    public function rejectChamberRequest(Request $request, Chamber $chamber)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        // Récupérer les données de la demande
        $applicationData = json_decode($chamber->certification_notes, true) ?? [];
        $applicationData['rejected_at'] = now();
        $applicationData['rejection_reason'] = $request->rejection_reason;

        $chamber->update([
            'verified' => false,
            'certification_notes' => json_encode($applicationData),
        ]);

        // Envoyer un email de refus
        $applicant = $chamber->members()->wherePivot('role', 'applicant')->first();
        if ($applicant) {
            try {
                Mail::to($applicant->email)->send(new ChamberRejectedMail($chamber, $request->rejection_reason));
            } catch (\Exception $e) {
                \Log::error('Erreur lors de l\'envoi de l\'email de refus: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Demande rejetée avec succès.');
    }

    /**
     * Affiche les demandes de création en attente
     */
    public function pendingRequests()
    {
        $pendingChambers = Chamber::where('verified', false)
            ->whereHas('members', function($query) {
                $query->wherePivot('role', 'applicant');
            })
            ->with(['members' => function($query) {
                $query->wherePivot('role', 'applicant');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.super-admin.pending-requests', compact('pendingChambers'));
    }

    /**
     * Retire la certification d'une chambre
     */
    public function uncertifyChamber(Chamber $chamber)
    {
        $chamber->update([
            'verified' => false,
            'state_number' => null,
            'certification_date' => null,
            'certification_notes' => null,
        ]);

        return redirect()->back()->with('success', 'Certification retirée avec succès.');
    }

    /**
     * Affiche la gestion détaillée d'une chambre (page dédiée)
     */
    public function manageChamber(Chamber $chamber)
    {
        try {
            $chamber->load(['members' => function($query) {
                $query->withPivot('role', 'status', 'created_at');
            }]);

            return view('admin.super-admin.chamber-manage-page', compact('chamber'));
        } catch (\Exception $e) {
            \Log::error('Erreur lors du chargement de la gestion de chambre: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Erreur lors du chargement des données de la chambre');
        }
    }

    /**
     * Retire un membre d'une chambre
     */
    public function removeMember(Request $request, Chamber $chamber)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);
        
        // Retirer l'utilisateur de la chambre
        $chamber->members()->detach($user->id);

        // Vérifier si l'utilisateur gère d'autres chambres
        $otherChambers = $user->chambers()->wherePivot('role', 'manager')->count();
        
        if ($otherChambers === 0 && $user->is_admin === User::ROLE_CHAMBER_MANAGER) {
            // Si plus de chambres à gérer, redevenir utilisateur normal
            $user->update(['is_admin' => User::ROLE_USER]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Membre retiré avec succès'
        ]);
    }
}