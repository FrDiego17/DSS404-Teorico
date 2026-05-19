<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->estado === 'inactivo') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Tu sesión ha sido cerrada porque tu cuenta fue suspendida.'
            ]);
        }

        if (!in_array(Auth::user()->rol, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
