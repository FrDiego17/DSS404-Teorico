<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TokenExpiradoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return response()->json([
                'message' => 'Token inválido o expirado, inicia sesión nuevamente',
            ], 401);
        }

        return $next($request);
    }
}