<?php

namespace App\Http\Controllers;

use App\Models\Chamber;
use App\Mail\ChamberRequestReceivedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ChamberPortalController extends Controller
{
    /**
     * Affiche la page principale du portail
     */
    public function index()
    {
        // Autoriser utilisateur normal ou gestionnaire
        if (!(Auth::user()->isRegularUser() || Auth::user()->isChamberManager())) {
            abort(403, 'Accès refusé. Cette fonctionnalité est réservée aux utilisateurs réguliers et gestionnaires.');
        }

        // Récupérer les demandes de l'utilisateur
        $userRequests = Auth::user()->chambers()
            ->wherePivot('role', 'applicant')
            ->with(['members' => function ($query) {
                $query->wherePivot('role', 'applicant');
            }])
            ->latest()
            ->take(5)
            ->get();

        // Statistiques pour l'utilisateur
        $stats = [
            'total_requests' => Auth::user()->chambers()->wherePivot('role', 'applicant')->count(),
            'pending_requests' => Auth::user()->chambers()->wherePivot('role', 'applicant')->where('verified', false)->count(),
            'approved_requests' => Auth::user()->chambers()->wherePivot('role', 'applicant')->where('verified', true)->count(),
        ];

        return view('portal.index', compact('userRequests', 'stats'));
    }

    /**
     * Affiche le formulaire de demande de création de chambre
     */
    public function create()
    {
        // Autoriser utilisateur normal ou gestionnaire
        if (!(Auth::user()->isRegularUser() || Auth::user()->isChamberManager())) {
            abort(403, 'Accès refusé. Cette fonctionnalité est réservée aux utilisateurs réguliers et gestionnaires.');
        }

        return view('portal.chamber.create');
    }

    /**
     * Traite la soumission de la demande de création de chambre
     */
    public function store(Request $request)
    {
        // Autoriser utilisateur normal ou gestionnaire
        if (!(Auth::user()->isRegularUser() || Auth::user()->isChamberManager())) {
            abort(403, 'Accès refusé. Cette fonctionnalité est réservée aux utilisateurs réguliers et gestionnaires.');
        }

        $request->validate([
            // Étape 1 - Informations générales
            'name' => 'required|string|max:255',
            'type' => 'required|in:national,bilateral',
            'embassy_country' => 'nullable|string|max:255',
            'embassy_address' => 'nullable|string|max:255',
            'sigle' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'required|string|max:2000',
            'creation_date' => 'required|date',
            'nina_number' => 'required|string|max:50',

            // Étape 2 - Documents
            'statuts' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'reglement_interieur' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'pv_assemblee' => 'required|file|mimes:pdf|max:10240',
            'liste_membres' => 'required|file|mimes:pdf,xlsx,xls|max:10240',
            'plan_action' => 'required|file|mimes:pdf|max:10240',
            'pieces_identite' => 'required|file|mimes:pdf|max:20480',
            'lettre_demande' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        // Créer le slug
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;

        while (Chamber::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Créer la chambre avec verified = false
        $chamber = Chamber::create([
            'name' => $request->name,
            'slug' => $slug,
            'type' => $request->type ?? 'national',
            'embassy_country' => $request->type === 'bilateral' ? $request->embassy_country : null,
            'embassy_address' => $request->type === 'bilateral' ? $request->embassy_address : null,
            'location' => $request->location,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'description' => $request->description,
            'verified' => false,
            'state_number' => null,
            'certification_date' => null,
            'certification_notes' => null,
        ]);

        // Sauvegarder les documents
        $this->saveDocuments($request, $chamber);

        // Associer l'utilisateur actuel comme demandeur
        $chamber->members()->attach(Auth::id(), [
            'role' => 'applicant',
            'status' => 'pending'
        ]);

        // Envoyer l'email de confirmation de réception
        try {
            Mail::to(Auth::user()->email)->send(new ChamberRequestReceivedMail($chamber, Auth::user()));
        } catch (\Exception $e) {
            // Log l'erreur mais ne pas interrompre le processus
            \Log::error('Erreur lors de l\'envoi de l\'email de confirmation: ' . $e->getMessage());
        }

        return redirect()->route('portal.chamber.success')
            ->with('success', 'Votre demande a été soumise avec succès. Vous recevrez un e-mail de confirmation sous peu.');
    }

    /**
     * Affiche la page de confirmation
     */
    public function success()
    {
        return view('portal.chamber.success');
    }

    /**
     * Sauvegarde les documents uploadés
     */
    private function saveDocuments(Request $request, Chamber $chamber)
    {
        $documents = [
            'statuts' => 'Statuts signés',
            'reglement_interieur' => 'Règlement intérieur',
            'pv_assemblee' => 'PV Assemblée constitutive',
            'liste_membres' => 'Liste des membres fondateurs',
            'plan_action' => 'Plan d\'action',
            'pieces_identite' => 'Pièces d\'identité',
            'lettre_demande' => 'Lettre de demande'
        ];

        $documentPaths = [];

        foreach ($documents as $key => $label) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $filename = $key . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs("chambers/{$chamber->slug}/documents", $filename, 'public');
                $documentPaths[$key] = $path;
            }
        }

        // Sauvegarder les chemins des documents dans un champ JSON ou une table séparée
        // Pour simplifier, on peut les stocker dans certification_notes temporairement
        $chamber->update([
            'certification_notes' => json_encode([
                'documents' => $documentPaths,
                'sigle' => $request->sigle,
                'creation_date' => $request->creation_date,
                'nina_number' => $request->nina_number,
                'submitted_at' => now(),
                'submitted_by' => Auth::id()
            ])
        ]);
    }

    /**
     * Affiche les demandes de l'utilisateur connecté
     */
    public function myRequests()
    {
        // Autoriser utilisateur normal ou gestionnaire
        if (!(Auth::user()->isRegularUser() || Auth::user()->isChamberManager())) {
            abort(403, 'Accès refusé. Cette fonctionnalité est réservée aux utilisateurs réguliers et gestionnaires.');
        }

        $chambers = Auth::user()->chambers()
            ->wherePivot('role', 'applicant')
            ->with(['members' => function ($query) {
                $query->wherePivot('role', 'applicant');
            }])
            ->paginate(10);

        return view('portal.chamber.my-requests', compact('chambers'));
    }
}
