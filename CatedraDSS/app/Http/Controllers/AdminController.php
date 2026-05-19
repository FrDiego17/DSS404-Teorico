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
            'accion' => 'required|in:verificada,rechazada,suspender,habilitar',
        ]);

        $organizacion = Organizacion::findOrFail($id);
        $user = $organizacion->user;

        if (in_array($request->accion, ['verificada', 'rechazada'])) {
            $organizacion->update(['estado_verificacion' => $request->accion]);
            $user->update(['estado' => $request->accion === 'verificada' ? 'activo' : 'rechazado']);
            $msg = $request->accion === 'verificada' ? "verificada exitosamente" : "rechazada";
        } elseif ($request->accion === 'suspender') {
            $user->update(['estado' => 'inactivo']);
            $msg = "suspendida temporalmente";
        } elseif ($request->accion === 'habilitar') {
            $user->update(['estado' => 'activo']);
            $msg = "habilitada nuevamente";
        }

        return redirect()->route('admin.ongs.index')
            ->with('success', "Organización \"{$organizacion->nombre_oficial}\" ha sido {$msg}.");
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
            'accion' => 'required|in:aprobado,rechazado,suspender,habilitar',
        ]);

        $comercio = Comercio::findOrFail($id);
        $user = $comercio->user;

        if (in_array($request->accion, ['aprobado', 'rechazado'])) {
            $comercio->update(['estado' => $request->accion]);
            $user->update(['estado' => $request->accion === 'aprobado' ? 'activo' : 'rechazado']);
            $msg = $request->accion === 'aprobado' ? "aprobado exitosamente" : "rechazado";
        } elseif ($request->accion === 'suspender') {
            $user->update(['estado' => 'inactivo']);
            $msg = "suspendido temporalmente";
        } elseif ($request->accion === 'habilitar') {
            $user->update(['estado' => 'activo']);
            $msg = "habilitado nuevamente";
        }

        return redirect()->route('admin.comercios.index')
            ->with('success', "Comercio \"{$comercio->nombre_comercial}\" ha sido {$msg}.");
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