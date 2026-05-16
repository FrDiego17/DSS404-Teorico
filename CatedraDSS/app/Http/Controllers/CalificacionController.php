<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Entrega;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    public function index(Request $request)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        $calificaciones = Calificacion::with(['entrega.reserva.donacion.comercio'])
            ->whereHas('entrega.reserva', function ($query) use ($organizacion) {
                $query->where('organizacion_id', $organizacion->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($calificaciones);
    }

    public function store(Request $request)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        $request->validate([
            'entrega_id' => 'required|exists:entregas,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
        ]);

        $entrega = Entrega::where('id', $request->entrega_id)->first();

        if (!$entrega) {
            return response()->json(['message' => 'Entrega no encontrada'], 404);
        }

        if ($entrega->reserva->organizacion_id !== $organizacion->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        if ($entrega->calificacion) {
            return response()->json(['message' => 'Ya calificaste esta entrega'], 400);
        }

        $calificacion = Calificacion::create([
            'entrega_id' => $entrega->id,
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
        ]);

        return response()->json([
            'message'      => 'Calificación guardada exitosamente',
            'calificacion' => $calificacion,
        ], 201);
    }
}