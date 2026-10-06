<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->activo || !$user->role || $user->role->nombre !== 'Administrador') {
            abort(403, 'Acceso denegado. Solo el Administrador puede gestionar usuarios.');
        }

        return $next($request);
    }
}



