<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Impacto;
use Illuminate\Support\Facades\Storage;

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
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $organizacion = auth()->user()->organizacion;

        if (!$organizacion) {
            return redirect()->back()->with('error', 'No se encontró un perfil de organización asociado.');
        }

        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('impactos', 'public');
        }

        Impacto::create([
            'organizacion_id' => $organizacion->id,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $rutaImagen,
        ]);

        return redirect()->back()->with('success', '¡Historia de impacto publicada con éxito!');
    }

    /* Actualiza la publicación de impacto */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $organizacion = auth()->user()->organizacion;

        $impacto = Impacto::where('id', $id)
            ->where('organizacion_id', $organizacion->id)
            ->firstOrFail();

        $dataToUpdate = [
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
        ];

        if ($request->hasFile('imagen')) {
            if ($impacto->imagen) {
                Storage::disk('public')->delete($impacto->imagen);
            }
            $dataToUpdate['imagen'] = $request->file('imagen')->store('impactos', 'public');
        }

        $impacto->update($dataToUpdate);

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

        if ($impacto->imagen) {
            Storage::disk('public')->delete($impacto->imagen);
        }

        $impacto->delete();

        return redirect()->back()->with('success', 'La historia de impacto ha sido eliminada.');
    }
}