<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application's locale.
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch($locale)
    {
        // Vérifie si la langue est supportée
        if (!in_array($locale, ['en', 'fr'])) {
            abort(400);
        }

        // Stocke la langue dans la session
        Session::put('locale', $locale);
        
        // Change la langue de l'application
        App::setLocale($locale);

        // Redirige vers la page précédente
        return redirect()->back();
    }
}