<?php

namespace App\Http\Controllers;

use App\Models\Donacion;
use App\Http\Requests\StoreDonacionRequest;
use Illuminate\Http\Request;

class DonacionController extends Controller
{
    // Muestra las donaciones disponibles (para ONGs)
    public function index(Request $request)
    {
        $donaciones = Donacion::with(['comercio', 'categoria'])
            ->where('estado', 'publicada')
            ->where('fecha_limite', '>', now())
            ->orderBy('fecha_limite', 'asc')
            ->get();

        return response()->json($donaciones);
    }

    // Publica una nueva donación (solo comercio)
    public function store(StoreDonacionRequest $request)
    {
        $comercio = $request->user()->comercio;

        if (!$comercio || $comercio->estado !== 'aprobado') {
            return response()->json([
                'message' => 'Tu comercio debe estar aprobado para publicar donaciones',
            ], 403);
        }

        $donacion = Donacion::create([
            'comercio_id'       => $comercio->id,
            'categoria_id'      => $request->categoria_id,
            'titulo'            => $request->titulo,
            'descripcion'       => $request->descripcion,
            'cantidad'          => $request->cantidad,
            'peso_estimado_kg'  => $request->peso_estimado_kg,
            'fecha_limite'      => $request->fecha_limite,
            'estado'            => 'publicada',
        ]);

        return response()->json([
            'message'  => 'Donación publicada exitosamente',
            'donacion' => $donacion->load('categoria'),
        ], 201);
    }

    // Muestra el detalle de una donación
    public function show($id)
    {
        $donacion = Donacion::with(['comercio', 'categoria'])->findOrFail($id);
        return response()->json($donacion);
    }

    // Cancelar donación (solo el comercio dueño)
    public function cancelar(Request $request, $id)
    {
        $donacion = Donacion::findOrFail($id);
        $comercio = $request->user()->comercio;

        if ($donacion->comercio_id !== $comercio->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        if ($donacion->estado !== 'publicada') {
            return response()->json([
                'message' => 'Solo se pueden cancelar donaciones publicadas',
            ], 400);
        }

        $donacion->update(['estado' => 'cancelada']);

        return response()->json(['message' => 'Donación cancelada']);
    }

    // Marca donaciones vencidas (se puede llamar desde un comando programado)
    public function marcarVencidas()
    {
        $cantidad = Donacion::where('estado', 'publicada')
            ->where('fecha_limite', '<', now())
            ->update(['estado' => 'vencida']);

        return response()->json([
            'message'  => 'Donaciones vencidas actualizadas',
            'cantidad' => $cantidad,
        ]);
    }

    // Historial de donaciones para la ONG autenticada (entregadas/canceladas)
    public function historialOng(Request $request)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json([]);
        }

        $reservas = \App\Models\Reserva::with(['donacion.comercio', 'donacion.categoria', 'voluntario'])
            ->where('organizacion_id', $organizacion->id)
            ->whereIn('estado', ['completada', 'cancelada'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $resultado = $reservas->map(function ($reserva) {
            $don = $reserva->donacion->toArray();
            $don['reserva_id']    = $reserva->id;
            $don['reserva_estado']= $reserva->estado;
            $don['voluntario']    = $reserva->voluntario;
            $don['reserva_notas'] = $reserva->notas;
            $don['updated_at']    = $reserva->updated_at; 
            return $don;
        });

        return response()->json($resultado);
    }

    // Donaciones reservadas 
    public function reservadosOng(Request $request)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json([]);
        }

        $reservas = \App\Models\Reserva::with(['donacion.comercio', 'donacion.categoria', 'voluntario'])
            ->where('organizacion_id', $organizacion->id)
            ->where('estado', 'activa')
            ->orderBy('created_at', 'desc')
            ->get();

        $resultado = $reservas->map(function ($reserva) {
            $don = $reserva->donacion->toArray();
            $don['reserva_id']    = $reserva->id;
            $don['reserva_estado']= $reserva->estado;
            $don['voluntario']    = $reserva->voluntario;
            $don['reserva_notas'] = $reserva->notas;
            return $don;
        });

        return response()->json($resultado);
    }
}