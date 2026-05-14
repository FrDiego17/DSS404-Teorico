<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // Muestra todas las categorías
    public function index()
    {
        return response()->json(Categoria::all());
    }

    // Crea una categoría 
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'icono'  => 'nullable|string',
        ]);

        $categoria = Categoria::create($request->only('nombre', 'icono'));

        return response()->json([
            'message'   => 'Categoría creada',
            'categoria' => $categoria,
        ], 201);
    }

    // Elimina una categoría 
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada']);
    }
}