<?php

namespace App\Http\Controllers;

use App\Models\Organizacion;
use App\Models\Donacion;
use App\Models\Comercio;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $ongsPendientes  = Organizacion::where('estado_verificacion', 'pendiente')->count();
        $totalDonaciones = Donacion::count();
        $totalKgSalvados = Donacion::where('estado', 'entregada')->sum('peso_estimado_kg');

        return view('admin.dashboard', compact('ongsPendientes', 'totalDonaciones', 'totalKgSalvados'));
    }

    //Organizaciones

    public function index()
    {
        $ongs = Organizacion::with('user')
            ->orderBy('nombre_oficial', 'asc')
            ->get();

        return view('admin.organizaciones', compact('ongs'));
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

        return view('admin.organizaciones', compact('ongs'));
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

        return redirect()->route('admin.ongs.index')
            ->with('success', $request->accion === 'verificada'
                ? "Organización \"{$organizacion->nombre_oficial}\" verificada exitosamente."
                : "Organización \"{$organizacion->nombre_oficial}\" rechazada.");
    }

    //Comercio

    public function comerciosIndex()
    {
        $comercios = Comercio::with('user')->orderBy('nombre_comercial', 'asc')->get();
        return view('admin.comercios', compact('comercios'));
    }

    public function verificarComercio(Request $request, $id)
    {
        $request->validate([
            'accion' => 'required|in:aprobado,rechazado',
        ]);

        $comercio = Comercio::findOrFail($id);
        $comercio->update(['estado' => $request->accion]);

        $user = $comercio->user;
        if ($request->accion === 'aprobado') {
            $user->update(['estado' => 'activo']);
        } else {
            $user->update(['estado' => 'rechazado']);
        }

        return redirect()->route('admin.comercios.index')
            ->with('success', $request->accion === 'aprobado'
                ? "Comercio \"{$comercio->nombre_comercial}\" aprobado exitosamente."
                : "Comercio \"{$comercio->nombre_comercial}\" rechazado.");
    }

    //Publicaciones

    public function publicacionesIndex()
    {
        $donaciones = Donacion::with(['categoria', 'comercio'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.publicaciones', compact('donaciones'));
    }

    //Reportes

    public function reportes()
    {
        return response()->json([
            'ongs_pendientes'  => Organizacion::where('estado_verificacion', 'pendiente')->count(),
            'total_donaciones' => Donacion::count(),
            'kg_salvados'      => Donacion::where('estado', 'entregada')->sum('peso_estimado_kg'),
        ]);
    }
}