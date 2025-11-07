<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPrivileges
{
    /**
     * Handle an incoming request.
     * Permet l'accès aux super admins et gestionnaires de chambre
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user || !$user->hasAdminPrivileges()) {
            abort(403, 'Accès réservé aux administrateurs et gestionnaires.');
        }
        
        return $next($request);
    }
}
