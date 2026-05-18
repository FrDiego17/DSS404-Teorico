<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\Donacion;
use App\Models\Categoria;
use App\Models\Organizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComercioController extends Controller
{
   //Dashboard

    public function dashboard()
    {
        $comercio = Auth::user()->comercio;
        $donacionesRecientes = [];
        $categorias = Categoria::all();

        if ($comercio) {
            $donacionesRecientes = Donacion::with('categoria')
                ->where('comercio_id', $comercio->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('comercio.dashboard', compact('donacionesRecientes', 'categorias'));
    }

    //Las donaciones

    public function donaciones()
    {
        $comercio   = Auth::user()->comercio;
        $categorias = Categoria::all();
        $donaciones = [];

        if ($comercio) {
            $donaciones = Donacion::with('categoria')
                ->where('comercio_id', $comercio->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('comercio.donaciones', compact('donaciones', 'categorias'));
    }

    public function storeDonacion(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'cantidad'     => 'required|integer|min:1',
            'fecha_limite' => 'required|date|after:now',
        ]);

        $comercio = Auth::user()->comercio;

        if (!$comercio) {
            return back()->withErrors(['error' => 'No se encontró el perfil de comercio.']);
        }

        Donacion::create([
            'comercio_id'  => $comercio->id,
            'categoria_id' => $request->categoria_id,
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'cantidad'     => $request->cantidad,
            'fecha_limite' => $request->fecha_limite,
            'estado'       => 'disponible',
        ]);

        return redirect()->route('comercio.donaciones')->with('success', '¡Excedente publicado con éxito!');
    }

    //Estadísticas

    public function estadisticas()
    {
        $comercio = Auth::user()->comercio;

        $totalDonaciones    = 0;
        $donacionesEntregadas = 0;
        $totalKg            = 0;
        $porCategoria       = collect();

        if ($comercio) {
            $totalDonaciones     = Donacion::where('comercio_id', $comercio->id)->count();
            $donacionesEntregadas = Donacion::where('comercio_id', $comercio->id)->where('estado', 'entregada')->count();
            $totalKg             = Donacion::where('comercio_id', $comercio->id)->where('estado', 'entregada')->sum('peso_estimado_kg');
            $porCategoria        = Categoria::withCount(['donaciones' => function ($q) use ($comercio) {
                $q->where('comercio_id', $comercio->id);
            }])->having('donaciones_count', '>', 0)->get()->map(function ($cat) {
                return (object)['nombre' => $cat->nombre, 'total' => $cat->donaciones_count];
            });
        }

        return view('comercio.estadisticas', compact('totalDonaciones', 'donacionesEntregadas', 'totalKg', 'porCategoria'));
    }

    //Impacto social

    public function impacto()
    {
        return view('comercio.impacto');
    }

    // organizaciones

    public function organizaciones()
    {
        $organizaciones = Organizacion::where('estado_verificacion', 'verificada')
            ->orderBy('nombre_oficial')
            ->get();

        return view('comercio.organizaciones', compact('organizaciones'));
    }

    // perfil

    public function perfil(Request $request)
    {
        $comercio = $request->user()->comercio;

        if (!$comercio) {
            return response()->json(['message' => 'Comercio no encontrado'], 404);
        }

        return response()->json($comercio);
    }

    public function actualizar(Request $request)
    {
        $comercio = $request->user()->comercio;

        $request->validate([
            'nombre_comercial' => 'sometimes|string|max:255',
            'telefono'         => 'sometimes|string|max:20',
            'direccion'        => 'sometimes|string|max:255',
            'latitud'          => 'sometimes|numeric',
            'longitud'         => 'sometimes|numeric',
            'horario_inicio'   => 'sometimes|string',
            'horario_fin'      => 'sometimes|string',
        ]);

        $comercio->update($request->only([
            'nombre_comercial', 'telefono', 'direccion',
            'latitud', 'longitud', 'horario_inicio', 'horario_fin',
        ]));

        return response()->json([
            'message'  => 'Perfil actualizado correctamente',
            'comercio' => $comercio,
        ]);
    }


    public function index()
    {
        $comercios = Comercio::where('estado', 'aprobado')->get();
        return response()->json($comercios);
    }
}