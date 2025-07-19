<?php

namespace App\Http\Middleware;

use Closure;

class AdminUser
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
        } else {
            if (!$_SESSION['user']['is_admin']) {
                return redirect('/'); // Redirige a la página principal si no es admin
            }
        }


        // Permite continuar
        return $next($request);
    }
}
