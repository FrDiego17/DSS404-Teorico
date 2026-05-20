<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\Donacion;
use App\Models\Categoria;
use App\Models\Entrega;
use App\Models\Organizacion;
use App\Models\Reserva;
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
            $donacionesRecientes = Donacion::with(['categoria', 'reservas' => function ($q) {
                $q->where('estado', 'activa');
            }])
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
            $donaciones = Donacion::with(['categoria', 'reservas' => function ($q) {
                $q->where('estado', 'activa');
            }])
                ->where('comercio_id', $comercio->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('comercio.donaciones', compact('donaciones', 'categorias'));
    }

    public function storeDonacion(Request $request)
    {
        $request->validate([
            'categoria_id'     => 'required|exists:categorias,id',
            'titulo'           => 'required|string|max:255',
            'descripcion'      => 'nullable|string',
            'cantidad'         => 'required|integer|min:1',
            'peso_estimado_kg' => 'nullable|numeric|min:0.01',
            'fecha_limite'     => 'required|date|after:now',
        ]);

        $comercio = Auth::user()->comercio;

        if (!$comercio) {
            return back()->withErrors(['error' => 'No se encontró el perfil de comercio.']);
        }

        Donacion::create([
            'comercio_id'      => $comercio->id,
            'categoria_id'     => $request->categoria_id,
            'titulo'           => $request->titulo,
            'descripcion'      => $request->descripcion,
            'cantidad'         => $request->cantidad,
            'peso_estimado_kg' => $request->peso_estimado_kg ?? 0,
            'fecha_limite'     => $request->fecha_limite,
            'estado'           => 'publicada',
        ]);

        return redirect()->route('comercio.donaciones')->with('success', '¡Excedente publicado con éxito!');
    }

    public function updateDonacion(Request $request, $id)
    {
        $request->validate([
            'categoria_id'     => 'required|exists:categorias,id',
            'titulo'           => 'required|string|max:255',
            'descripcion'      => 'nullable|string',
            'cantidad'         => 'required|integer|min:1',
            'peso_estimado_kg' => 'nullable|numeric|min:0',
            'fecha_limite'     => 'required|date|after:now',
        ]);

        $comercio = Auth::user()->comercio;
        $donacion = Donacion::where('id', $id)->where('comercio_id', $comercio->id)->firstOrFail();

        $donacion->update([
            'categoria_id'     => $request->categoria_id,
            'titulo'           => $request->titulo,
            'descripcion'      => $request->descripcion,
            'cantidad'         => $request->cantidad,
            'peso_estimado_kg' => $request->peso_estimado_kg ?? 0,
            'fecha_limite'     => $request->fecha_limite,
        ]);

        return back()->with('success', '¡Publicación actualizada con éxito!');
    }

    public function destroyDonacion($id)
    {
        $comercio = Auth::user()->comercio;
        $donacion = Donacion::where('id', $id)->where('comercio_id', $comercio->id)->firstOrFail();

        if (in_array($donacion->estado, ['reservada', 'entregada'])) {
            return back()->withErrors(['error' => 'No se puede eliminar una donación que ya fue reservada o entregada.']);
        }

        $donacion->delete();

        return redirect()->route('comercio.donaciones')->with('success', 'Publicación eliminada correctamente.');
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
            ->whereHas('user', function ($query) {
                $query->where('estado', 'activo');
            })
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
        $comercios = Comercio::where('estado', 'aprobado')
            ->whereHas('user', function ($query) {
                $query->where('estado', 'activo');
            })
            ->get();
        return response()->json($comercios);
    }

    public function verificarEntrega(Request $request)
    {
        $request->validate([
            'donacion_id' => 'required|integer',
            'codigo'      => 'required|string|size:4',
        ]);

        $comercio = Auth::user()->comercio;

        if (!$comercio) {
            return response()->json(['message' => 'Comercio no encontrado'], 404);
        }

        // Buscar la donación que pertenece a este comercio (puede estar publicada o reservada)
        $donacion = Donacion::where('id', $request->donacion_id)
            ->where('comercio_id', $comercio->id)
            ->whereIn('estado', ['publicada', 'reservada'])
            ->first();

        if (!$donacion) {
            return response()->json(['message' => 'Donación no encontrada o no es válida para verificar'], 404);
        }

        // Buscar la reserva activa con ese código
        $reserva = Reserva::where('donacion_id', $donacion->id)
            ->where('estado', 'activa')
            ->where('codigo_verificacion', $request->codigo)
            ->where('codigo_usado', false)
            ->first();

        if (!$reserva) {
            return response()->json(['message' => 'Código incorrecto o ya utilizado'], 422);
        }

        // Crear registro de entrega
        Entrega::create([
            'reserva_id'          => $reserva->id,
            'fecha_entrega'       => now(),
            'codigo_verificacion' => $request->codigo,
            'comentarios_entrega' => 'Entrega verificada mediante código PIN.',
        ]);

        // Actualizar estados
        $reserva->update([
            'estado'       => 'completada',
            'codigo_usado' => true,
        ]);

        // Verificar si la donación ya se puede dar por "entregada"
        $quedanReservasActivas = Reserva::where('donacion_id', $donacion->id)
            ->where('estado', 'activa')
            ->exists();

        if (($donacion->cantidad == 0 || $donacion->estado === 'reservada') && !$quedanReservasActivas) {
            $donacion->update(['estado' => 'entregada']);
        }

        return response()->json([
            'message'   => '¡Entrega verificada correctamente!',
            'donacion'  => $donacion->titulo,
        ]);
    }
}