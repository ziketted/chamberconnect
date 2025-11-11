<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Affiche la page des paramètres
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Met à jour les préférences de thème de l'utilisateur
     */
    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme_preference' => 'required|in:system,light,dark'
        ]);

        $user = Auth::user();
        $user->theme_preference = $request->theme_preference;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Préférence de thème mise à jour avec succès',
            'theme' => $request->theme_preference
        ]);
    }
}