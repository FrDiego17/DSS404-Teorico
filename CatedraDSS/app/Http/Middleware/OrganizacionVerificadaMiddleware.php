<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizacionVerificadaMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->rol !== 'organizacion') {
            abort(403, 'Solo las organizaciones pueden acceder a esta sección.');
        }

        $organizacion = $user->organizacion;

        if (!$organizacion) {
            abort(403, 'No tienes una organización vinculada.');
        }

        if ($organizacion->estado_verificacion !== 'verificada') {
            abort(403, 'Tu organización debe estar verificada para acceder a esta sección.');
        }

        return $next($request);
    }
}