<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Http\Requests\SubirDocumentoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index(Request $request)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        $documentos = Documento::where('organizacion_id', $organizacion->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($documentos);
    }

    public function store(SubirDocumentoRequest $request)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        $file = $request->file('documento');
        $nombre = time() . '_' . $file->getClientOriginalName();
        $ruta = $file->storeAs('documentos', $nombre, 'public');

        $documento = Documento::create([
            'organizacion_id'  => $organizacion->id,
            'nombre_documento' => $file->getClientOriginalName(),
            'ruta_archivo'     => $ruta,
            'tipo'             => $request->tipo,
        ]);

        return response()->json([
            'message'   => 'Documento subido exitosamente',
            'documento' => $documento,
        ], 201);
    }

    public function destroy(Request $request, $id)
    {
        $organizacion = $request->user()->organizacion;

        if (!$organizacion) {
            return response()->json(['message' => 'No tienes una organización vinculada'], 404);
        }

        $documento = Documento::where('id', $id)
            ->where('organizacion_id', $organizacion->id)
            ->firstOrFail();

        Storage::disk('public')->delete($documento->ruta_archivo);
        $documento->delete();

        return response()->json(['message' => 'Documento eliminado exitosamente']);
    }
}