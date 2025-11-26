<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chamber;
use Illuminate\Http\Request;

class SuperAdminNotificationController extends Controller
{
    /**
     * Affiche la page des notifications SuperAdmin
     */
    public function index()
    {
        $chambers = Chamber::all();

        return view('admin.super-admin.notifications.index', compact('chambers'));
    }

    /**
     * Envoie une notification en masse
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'target' => 'required|in:all,specific',
            'chambers' => 'required_if:target,specific|array',
            'subject' => 'required|string|min:5',
            'message' => 'required|string|min:10',
            'send_email' => 'boolean',
        ]);

        // TODO: Implémenter la logique d'envoi
        // - Récupérer les destinataires selon le target
        // - Envoyer les emails
        // - Enregistrer dans l'historique

        return redirect()->route('super-admin.notifications.index')
            ->with('success', 'Notification envoyée avec succès!');
    }
}
