<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use App\Models\Reserva;
use App\Http\Requests\ConfirmarEntregaRequest;
use Illuminate\Http\Request;

class EntregaController extends Controller
{
    public function index(Request $request)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        $entregas = Entrega::with(['reserva.donacion.comercio', 'calificacion'])
            ->whereHas('reserva', function ($query) use ($organizacion) {
                $query->where('organizacion_id', $organizacion->id);
            })
            ->orderBy('fecha_entrega', 'desc')
            ->get();

        return response()->json($entregas);
    }

    public function store(ConfirmarEntregaRequest $request)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        $reserva = Reserva::where('id', $request->reserva_id)
            ->where('organizacion_id', $organizacion->id)
            ->first();

        if (!$reserva) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        if ($reserva->estado !== 'activa') {
            return response()->json(['message' => 'Esta reserva no está activa'], 400);
        }

        $entrega = Entrega::create([
            'reserva_id'          => $reserva->id,
            'fecha_entrega'       => now(),
            'codigo_verificacion' => $request->codigo_verificacion,
            'comentarios_entrega' => $request->comentarios_entrega,
        ]);

        $reserva->update(['estado' => 'completada']);
        $reserva->donacion->update(['estado' => 'entregada']);

        return response()->json([
            'message' => 'Entrega confirmada exitosamente',
            'entrega' => $entrega,
        ], 201);
    }
}