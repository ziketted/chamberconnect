<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
            'chamber.manager' => \App\Http\Middleware\EnsureChamberManager::class,
            'admin.privileges' => \App\Http\Middleware\EnsureAdminPrivileges::class,
            'regular.user' => \App\Http\Middleware\EnsureRegularUser::class,
            'locale' => \App\Http\Middleware\SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Gérer l'erreur 419 (CSRF Token Mismatch / Page Expired)
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($e->getStatusCode() === 419) {
                // Si c'est une requête AJAX, retourner une réponse JSON
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Votre session a expiré. Veuillez vous reconnecter.',
                        'redirect' => route('login')
                    ], 419);
                }
                
                // Sinon, rediriger vers la page de login avec un message
                return redirect()->route('login')
                    ->with('error', 'Votre session a expiré. Veuillez vous reconnecter.');
            }
        });
    })->create();
