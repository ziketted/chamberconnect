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

    /**
     * Met à jour le profil de l'utilisateur
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:100',
            'professional_email' => 'nullable|string|email|max:255',
        ]);

        $user = Auth::user();
        $user->update($request->only([
            'name',
            'email',
            'phone',
            'company',
            'nationality',
            'professional_email'
        ]));

        return redirect()->back()->with('success', 'Profil mis à jour avec succès');
    }
}