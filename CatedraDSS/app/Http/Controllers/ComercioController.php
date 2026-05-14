<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Http\Request;

class ComercioController extends Controller
{
    // Muestra el perfil del comercio autenticado
    public function perfil(Request $request)
    {
        $comercio = $request->user()->comercio;

        if (!$comercio) {
            return response()->json(['message' => 'Comercio no encontrado'], 404);
        }

        return response()->json($comercio);
    }

    // Actualiza el perfil
    public function actualizar(Request $request)
    {
        $comercio = $request->user()->comercio;

        $request->validate([
            'nombre_comercial' => 'sometimes|string|max:255',
            'telefono'         => 'sometimes|string|max:20',
            'direccion'        => 'sometimes|string|max:255',
            'latitud'          => 'sometimes|numeric',
            'longitud'         => 'sometimes|numeric',
            'horario_inicio'   => 'sometimes|string',
            'horario_fin'      => 'sometimes|string',
        ]);

        $comercio->update($request->only([
            'nombre_comercial',
            'telefono',
            'direccion',
            'latitud',
            'longitud',
            'horario_inicio',
            'horario_fin',
        ]));

        return response()->json([
            'message'  => 'Perfil actualizado correctamente',
            'comercio' => $comercio,
        ]);
    }

    // Historial de donaciones del comercio
    public function misDonaciones(Request $request)
    {
        $donaciones = $request->user()->comercio
            ->donaciones()
            ->with('categoria')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($donaciones);
    }

    // Muestra todos los comercios (para ONGs y admin)
    public function index()
    {
        $comercios = Comercio::where('estado', 'aprobado')->get();
        return response()->json($comercios);
    }
}