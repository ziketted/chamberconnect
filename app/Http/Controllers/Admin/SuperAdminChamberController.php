<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chamber;
use Illuminate\Http\Request;

class SuperAdminChamberController extends Controller
{
    /**
     * Affiche les détails d'une demande de création de chambre
     */
    public function showRequest($id)
    {
        $chamber = Chamber::findOrFail($id);
        return view('admin.super-admin.chambers.show-request', compact('chamber'));
    }

    /**
     * Affiche la liste des chambres pour le SuperAdmin
     */
    public function index(Request $request)
    {
        $query = Chamber::query()->with(['members' => function($query) {
            $query->withPivot('role');
        }]);

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('state_number', 'like', "%{$search}%");
            });
        }

        // Filtres par statut
        if ($request->filled('filter_status')) {
            switch ($request->filter_status) {
                case 'pending':
                    $query->where('verified', false);
                    break;
                case 'verified':
                    $query->where('verified', true)->whereNull('state_number');
                    break;
                case 'certified':
                    $query->where('verified', true)->whereNotNull('state_number');
                    break;
                case 'suspended':
                    $query->where('is_suspended', true);
                    break;
                case 'active':
                    $query->where('is_suspended', false);
                    break;
            }
        }

        // Tri
        switch ($request->get('sort', 'created_at')) {
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'location':
                $query->orderBy('location', 'asc');
                break;
            case 'members_count':
                $query->withCount('members')->orderBy('members_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $chambers = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Chamber::count(),
            'pending' => Chamber::where('verified', false)->count(),
            'verified' => Chamber::where('verified', true)->whereNull('state_number')->count(),
            'certified' => Chamber::where('verified', true)->whereNotNull('state_number')->count(),
            'suspended' => Chamber::where('is_suspended', true)->count(),
            'active' => Chamber::where('is_suspended', false)->count(),
        ];

        return view('admin.super-admin.chambers', compact('chambers', 'stats'));
    }

    /**
     * Certifie une chambre avec un numéro d'état
     */
    public function certify(Request $request, $id)
    {
        $chamber = Chamber::findOrFail($id);
        
        // Vérifier si le numéro d'état existe déjà
        $existingStateNumber = Chamber::where('state_number', $request->state_number)
            ->whereNotNull('state_number')
            ->first();
        
        if ($existingStateNumber) {
            return redirect()->route('super-admin.chambers.show-request', $chamber->id)
                ->with('error', "❌ Le numéro d'état '{$request->state_number}' existe déjà! Veuillez en utiliser un autre.");
        }
        
        $validated = $request->validate([
            'state_number' => 'required|string',
            'certification_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Récupérer les données JSON existantes
        $certificationNotes = json_decode($chamber->certification_notes, true) ?? [];
        
        // Ajouter les infos de certification
        $certificationNotes['state_number'] = $validated['state_number'];
        $certificationNotes['certification_date'] = $validated['certification_date'];
        $certificationNotes['certification_notes'] = $validated['notes'] ?? null;
        $certificationNotes['certified_at'] = now()->toDateTimeString();
        $certificationNotes['certified_by_user_id'] = auth()->id();

        $chamber->update([
            'state_number' => $validated['state_number'],
            'certification_date' => $validated['certification_date'],
            'certification_notes' => json_encode($certificationNotes),
            'verified' => true,
        ]);

        return redirect()->route('super-admin.chambers.show-request', $chamber->id)
            ->with('success', "✅ Chambre '{$chamber->name}' certifiée avec succès! Numéro d'état: {$validated['state_number']}");
    }

    /**
     * Approuve une demande de création de chambre
     */
    public function approve(Request $request, $id)
    {
        $chamber = Chamber::findOrFail($id);
        
        $chamber->update([
            'verified' => true,
        ]);

        // TODO: Envoyer email de notification

        return redirect()->route('super-admin.chambers.index')
            ->with('success', "Demande approuvée pour '{$chamber->name}'");
    }

    /**
     * Rejette une demande de création de chambre
     */
    public function reject(Request $request, $id)
    {
        $chamber = Chamber::findOrFail($id);
        
        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);

        $chamber->update([
            'rejection_reason' => $validated['rejection_reason'],
            'status' => 'rejected',
        ]);

        // TODO: Envoyer email de notification

        return redirect()->route('super-admin.chambers.index')
            ->with('success', "Demande rejetée pour '{$chamber->name}'");
    }

    /**
     * Supprime une chambre
     */
    public function delete($id)
    {
        $chamber = Chamber::findOrFail($id);
        $chamberName = $chamber->name;
        $chamber->delete();

        return redirect()->route('super-admin.chambers.index')
            ->with('success', "Chambre '{$chamberName}' supprimée avec succès!");
    }

    /**
     * Suspendre une chambre
     */
    public function suspend(Request $request, $id)
    {
        $chamber = Chamber::findOrFail($id);
        
        $validated = $request->validate([
            'suspension_reason' => 'required|string|min:10|max:500',
        ]);

        $chamber->suspend($validated['suspension_reason']);

        return redirect()->route('super-admin.chambers.index')
            ->with('success', "Chambre '{$chamber->name}' suspendue avec succès!");
    }

    /**
     * Réactiver une chambre
     */
    public function reactivate($id)
    {
        $chamber = Chamber::findOrFail($id);
        
        $chamber->reactivate();

        return redirect()->route('super-admin.chambers.index')
            ->with('success', "Chambre '{$chamber->name}' réactivée avec succès!");
    }
}
