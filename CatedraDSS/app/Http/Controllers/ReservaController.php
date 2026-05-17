<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Donacion;
use App\Http\Requests\StoreReservaRequest;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        $reservas = Reserva::with(['donacion.comercio', 'donacion.categoria', 'entrega'])
            ->where('organizacion_id', $organizacion->id)
            ->orderBy('fecha_reserva', 'desc')
            ->get();

        return response()->json($reservas);
    }

    public function show(Request $request, $id)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        $reserva = Reserva::with(['donacion.comercio', 'donacion.categoria', 'entrega.calificacion'])
            ->where('id', $id)
            ->where('organizacion_id', $organizacion->id)
            ->firstOrFail();

        return response()->json($reserva);
    }

    public function store(StoreReservaRequest $request, $donacion_id)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        $donacion = Donacion::with('comercio')->findOrFail($donacion_id);

        if ($donacion->estado !== 'publicada') {
            return response()->json(['message' => 'Esta donación ya no está disponible'], 400);
        }

        if ($donacion->fecha_limite < now()) {
            return response()->json(['message' => 'Esta donación ha expirado'], 400);
        }

        $reserva = Reserva::create([
            'donacion_id'     => $donacion->id,
            'organizacion_id' => $organizacion->id,
            'fecha_reserva'   => now(),
            'estado'          => 'activa',
            'notas'           => $request->notas,
        ]);

        $donacion->update(['estado' => 'reservada']);

        return response()->json([
            'message' => 'Donación reservada exitosamente',
            'reserva' => $reserva->load('donacion.comercio'),
        ], 201);
    }

    public function cancelar(Request $request, $id)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        $reserva = Reserva::where('id', $id)
            ->where('organizacion_id', $organizacion->id)
            ->firstOrFail();

        if ($reserva->estado !== 'activa') {
            return response()->json(['message' => 'Solo se pueden cancelar reservas activas'], 400);
        }

        $reserva->update(['estado' => 'cancelada']);
        $reserva->donacion->update(['estado' => 'publicada']);

        return response()->json(['message' => 'Reserva cancelada exitosamente']);
    }
}