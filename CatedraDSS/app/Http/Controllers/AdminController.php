<?php

namespace App\Http\Controllers;

use App\Models\Organizacion;
use App\Models\Donacion;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $ongsPendientes = Organizacion::where('estado_verificacion', 'pendiente')->count();
        $totalDonaciones = Donacion::count();
        $totalKgSalvados = Donacion::where('estado', 'entregada')->sum('peso_estimado_kg');

        return view('admin.dashboard', compact('ongsPendientes', 'totalDonaciones', 'totalKgSalvados'));
    }

    public function index()
    {
        $ongs = Organizacion::with('user')
            ->orderBy('nombre_oficial', 'asc')
            ->get();

        return response()->json($ongs);
    }

    public function show($id)
    {
        $organizacion = Organizacion::with(['user', 'documentos', 'reservas.donacion'])->findOrFail($id);

        return response()->json($organizacion);
    }

    public function ongsPendientes()
    {
        $ongs = Organizacion::with('user')
            ->where('estado_verificacion', 'pendiente')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($ongs);
    }

    public function verificarOng(Request $request, $id)
    {
        $request->validate([
            'accion' => 'required|in:verificada,rechazada',
        ]);

        $organizacion = Organizacion::findOrFail($id);
        $organizacion->update(['estado_verificacion' => $request->accion]);

        $user = $organizacion->user;
        if ($request->accion === 'verificada') {
            $user->update(['estado' => 'activo']);
        } else {
            $user->update(['estado' => 'rechazado']);
        }

        return response()->json([
            'message'      => $request->accion === 'verificada'
                ? 'Organización verificada exitosamente'
                : 'Organización rechazada',
            'organizacion' => $organizacion,
        ]);
    }
}