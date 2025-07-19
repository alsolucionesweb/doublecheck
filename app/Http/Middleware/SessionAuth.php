<?php

namespace App\Http\Middleware;

use Closure;

class SessionAuth
{
    public function handle($request, Closure $next)
    {
        // Asegura que la sesión esté iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Verifica si hay un usuario logueado
        if (!isset($_SESSION['user'])) {
            return redirect('/login'); // O response('Unauthorized', 401);
        }

        // Permite continuar
        return $next($request);
    }
}
