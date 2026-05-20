<?php

namespace App\Http\Controllers;

use App\Models\Donacion;
use App\Models\Organizacion;
use App\Models\Comercio;
use App\Models\Reserva;
use App\Models\Entrega;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {
        $totalDonaciones = Donacion::count();
        $donacionesEntregadas = Donacion::where('estado', 'entregada')->count();
        $donacionesCanceladas = Donacion::where('estado', 'cancelada')->count();
        $donacionesVencidas = Donacion::where('estado', 'vencida')->count();

        $totalKgSalvados = Donacion::where('estado', 'entregada')
            ->sum('peso_estimado_kg');

        $ongsActivas = Organizacion::where('estado_verificacion', 'verificada')
            ->whereHas('user', function ($query) {
                $query->where('estado', 'activo');
            })->count();
        $comerciosActivos = Comercio::where('estado', 'aprobado')
            ->whereHas('user', function ($query) {
                $query->where('estado', 'activo');
            })->count();

        $totalReservas = Reserva::count();
        $reservasCompletadas = Reserva::where('estado', 'completada')->count();

        return response()->json([
            'donaciones' => [
                'total'       => $totalDonaciones,
                'entregadas'  => $donacionesEntregadas,
                'canceladas'  => $donacionesCanceladas,
                'vencidas'    => $donacionesVencidas,
                'kg_salvados' => $totalKgSalvados,
            ],
            'organizaciones' => [
                'activas' => $ongsActivas,
            ],
            'comercios' => [
                'activos' => $comerciosActivos,
            ],
            'reservas' => [
                'total'       => $totalReservas,
                'completadas' => $reservasCompletadas,
            ],
        ]);
    }

    public function porPeriodo(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $inicio = $request->fecha_inicio;
        $fin = $request->fecha_fin;

        $donaciones = Donacion::whereBetween('created_at', [$inicio, $fin]);
        $totalDonaciones = $donaciones->count();
        $donacionesEntregadas = (clone $donaciones)->where('estado', 'entregada')->count();
        $totalKgSalvados = (clone $donaciones)->where('estado', 'entregada')->sum('peso_estimado_kg');

        $reservas = Reserva::whereBetween('created_at', [$inicio, $fin]);
        $totalReservas = $reservas->count();
        $reservasCompletadas = (clone $reservas)->where('estado', 'completada')->count();

        return response()->json([
            'periodo' => [
                'inicio' => $inicio,
                'fin'    => $fin,
            ],
            'donaciones' => [
                'total'      => $totalDonaciones,
                'entregadas' => $donacionesEntregadas,
                'kg_salvados' => $totalKgSalvados,
            ],
            'reservas' => [
                'total'       => $totalReservas,
                'completadas' => $reservasCompletadas,
            ],
        ]);
    }

    public function exportar()
    {
        $donaciones = Donacion::with(['comercio', 'categoria', 'reservas.organizacion'])
            ->orderBy('created_at', 'desc')
            ->get();

        $csv = "ID,Titulo,Comercio,Categoria,Cantidad,Peso (kg),Estado,Fecha Limite\n";

        foreach ($donaciones as $donacion) {
            $csv .= sprintf(
                "%s,%s,%s,%s,%s,%s,%s,%s\n",
                $donacion->id,
                $donacion->titulo,
                $donacion->comercio?->nombre_comercial ?? 'N/A',
                $donacion->categoria?->nombre ?? 'N/A',
                $donacion->cantidad,
                $donacion->peso_estimado_kg,
                $donacion->estado,
                $donacion->fecha_limite
            );
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="reporte_donaciones.csv"',
        ]);
    }
}