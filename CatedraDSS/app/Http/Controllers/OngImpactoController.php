<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Impacto;

class OngImpactoController extends Controller
{
    /* Muestra los impactos creados por la ong */
    public function index()
    {
        $organizacion = auth()->user()->organizacion;

        $misImpactos = $organizacion ? $organizacion->impactos()->latest()->get() : [];

        return view('ong.impactos', compact('misImpactos'));
    }

    /* Guarda el nuevo impacto en la bd*/
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        $organizacion = auth()->user()->organizacion;

        if (!$organizacion) {
            return redirect()->back()->with('error', 'No se encontró un perfil de organización asociado.');
        }

        Impacto::create([
            'organizacion_id' => $organizacion->id,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->back()->with('success', '¡Historia de impacto publicada con éxito!');
    }

    /* Actualiza la publicación de impacto */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        $organizacion = auth()->user()->organizacion;

        $impacto = Impacto::where('id', $id)
            ->where('organizacion_id', $organizacion->id)
            ->firstOrFail();

        $impacto->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->back()->with('success', '¡Historia de impacto actualizada correctamente!');
    }

    /* Elimina el impacto */
    public function destroy($id)
    {
        $organizacion = auth()->user()->organizacion;

        // Buscar el impacto asegurándonos de que pertenezca a esta ONG antes de borrar
        $impacto = Impacto::where('id', $id)
            ->where('organizacion_id', $organizacion->id)
            ->firstOrFail();

        $impacto->delete();

        return redirect()->back()->with('success', 'La historia de impacto ha sido eliminada.');
    }
}