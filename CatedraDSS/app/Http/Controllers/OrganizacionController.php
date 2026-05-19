<?php

namespace App\Http\Controllers;

use App\Models\Organizacion;
use Illuminate\Http\Request;
use App\Models\Voluntario;
use App\Models\Comercio;

class OrganizacionController extends Controller
{
    public function index()
    {
        $ongs = Organizacion::with('user')
            ->orderBy('nombre_oficial', 'asc')
            ->get();
        return response()->json($ongs);
    }
    public function perfil(Request $request)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        return response()->json($organizacion->load('user'));
    }

    public function actualizar(Request $request)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        $validated = $request->validate([
            'nombre_oficial'      => 'sometimes|string|max:255',
            'representante_legal' => 'sometimes|string|max:255',
            'mision'              => 'sometimes|nullable|string',
            'telefono_contacto'   => 'sometimes|string|max:20',
            'direccion'           => 'sometimes|string|max:255',
        ]);

        $organizacion->update($validated);

        return response()->json([
            'message'       => 'Perfil actualizado exitosamente',
            'organizacion'  => $organizacion,
        ]);
    }

    public function dashboard()
    {
        $voluntarios = Voluntario::where('user_id', auth()->id())->get();

        return view('ong.dashboard', compact('voluntarios'));
    }

    public function listarProveedores()
    {
        $proveedores = Comercio::all();

        return view('ong.proveedores', compact('proveedores'));
    }
}