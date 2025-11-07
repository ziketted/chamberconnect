<?php

namespace App\Http\Middleware;

use App\Models\Chamber;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureChamberManager
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Authentification requise.');
        }

        // Super admin a accès à tout
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Vérifier si l'utilisateur est gestionnaire de chambre
        if (!$user->isChamberManager()) {
            abort(403, 'Accès réservé aux gestionnaires de chambre.');
        }

        /** @var Chamber|null $chamber */
        $chamber = $request->route('chamber');

        if ($chamber instanceof Chamber) {
            // Vérifier si le gestionnaire est assigné à cette chambre
            $isManager = $chamber->members()
                ->where('user_id', $user->id)
                ->wherePivot('role', 'manager')
                ->exists();
                
            if (!$isManager) {
                abort(403, 'Vous n\'êtes pas gestionnaire de cette chambre.');
            }
        }

        return $next($request);
    }
}


