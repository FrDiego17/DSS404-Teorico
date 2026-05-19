<?php

namespace App\Http\Controllers;

use App\Mail\CodigoEntregaMail;
use App\Models\Reserva;
use App\Models\Donacion;
use App\Models\Voluntario;
use App\Http\Requests\StoreReservaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        $cantidadReservada = $request->cantidad_reservada ?? $donacion->cantidad;

        if ($cantidadReservada > $donacion->cantidad) {
            return response()->json([
                'message' => "Solo hay {$donacion->cantidad} unidades disponibles."
            ], 422);
        }

        $reserva = Reserva::create([
            'donacion_id'       => $donacion->id,
            'organizacion_id'   => $organizacion->id,
            'fecha_reserva'     => now(),
            'estado'            => 'activa',
            'notas'             => $request->notas ?? 'Cantidad reservada: ' . $cantidadReservada . ' unidad(es)',
        ]);

        // Si se reserva menos del total, reducir la cantidad disponible
        if ($cantidadReservada < $donacion->cantidad) {
            $donacion->update([
                'cantidad' => $donacion->cantidad - $cantidadReservada,
            ]);
            // Solo marcar como reservada si se agotó el stock
        } else {
            $donacion->update(['estado' => 'reservada']);
        }

        // Si se seleccionó un voluntario, se asigna de inmediato
        if ($request->filled('voluntario_id')) {
            $this->_procesarAsignacionVoluntario($reserva, $request->voluntario_id, $request->user()->id);
        }

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

    public function asignarVoluntario(Request $request, $id)
    {
        $request->validate([
            'voluntario_id' => 'required|integer',
        ]);

        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        $reserva = Reserva::with(['donacion.comercio'])
            ->where('id', $id)
            ->where('organizacion_id', $organizacion->id)
            ->where('estado', 'activa')
            ->first();

        if (!$reserva) {
            return response()->json(['message' => 'Reserva no encontrada o no está activa'], 404);
        }

        $resultado = $this->_procesarAsignacionVoluntario($reserva, $request->voluntario_id, $request->user()->id);

        if (!$resultado['success']) {
            return response()->json(['message' => $resultado['message']], 422);
        }

        return response()->json([
            'message'    => 'Voluntario asignado y código enviado al correo correctamente.',
            'voluntario' => $resultado['voluntario'],
        ]);
    }

    private function _procesarAsignacionVoluntario(Reserva $reserva, $voluntario_id, $user_id)
    {
        $voluntario = Voluntario::where('id', $voluntario_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$voluntario) {
            return ['success' => false, 'message' => 'Voluntario no válido para esta organización'];
        }

        if (!$voluntario->email) {
            return ['success' => false, 'message' => 'El voluntario no tiene correo registrado'];
        }

        // Generar PIN de 4 dígitos
        $codigo = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

        $reserva->update([
            'voluntario_id'       => $voluntario->id,
            'codigo_verificacion' => $codigo,
            'codigo_usado'        => false,
        ]);

        $comercio = $reserva->donacion->comercio;
        $horario  = ($comercio->horario_inicio && $comercio->horario_fin)
            ? $comercio->horario_inicio . ' – ' . $comercio->horario_fin
            : 'Consultar con el comercio';

        try {
            Mail::to($voluntario->email)->send(new CodigoEntregaMail(
                $voluntario->nombre,
                $comercio->nombre_comercial,
                $comercio->direccion ?? 'Sin dirección registrada',
                $horario,
                $reserva->donacion->titulo,
                $codigo
            ));
        } catch (\Exception $e) {
            \Log::error('Error enviando correo de entrega: ' . $e->getMessage());
        }

        return ['success' => true, 'voluntario' => $voluntario->nombre];
    }
}