<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Vérifie que l'utilisateur est SuperAdmin
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isSuperAdmin()) {
            abort(403, 'Accès SuperAdmin requis');
        }

        return $next($request);
    }
}


