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
            abort(403);
        }

        /** @var Chamber|null $chamber */
        $chamber = $request->route('chamber');

        if ($chamber instanceof Chamber) {
            $isManager = $chamber->members()
                ->where('user_id', $user->id)
                ->wherePivot('role', 'manager')
                ->exists();
        } else {
            $isManager = false;
        }

        if (!$isManager) {
            abort(403);
        }

        return $next($request);
    }
}


