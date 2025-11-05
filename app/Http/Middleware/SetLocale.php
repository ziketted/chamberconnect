<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $supportedLocales = ['fr', 'en'];
        
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } else {
            // Détecte la langue du navigateur
            $acceptLanguage = $request->server('HTTP_ACCEPT_LANGUAGE');
            $locale = $acceptLanguage ? substr($acceptLanguage, 0, 2) : 'fr';
            
            // Si la langue n'est pas supportée, utilise le français par défaut (RDC)
            if (!in_array($locale, $supportedLocales)) {
                $locale = config('app.locale', 'fr');
            }
            
            Session::put('locale', $locale);
        }

        // Vérification finale de sécurité
        if (!in_array($locale, $supportedLocales)) {
            $locale = 'fr';
            Session::put('locale', $locale);
        }

        App::setLocale($locale);
        
        return $next($request);
    }
}