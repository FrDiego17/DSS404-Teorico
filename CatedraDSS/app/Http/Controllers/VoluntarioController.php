<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voluntario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VoluntarioController extends Controller
{
    public function index()
    {
        $voluntarios = Voluntario::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return response()->json($voluntarios);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'           => 'required|string|max:255',
            'email'            => 'nullable|email|max:255',
            'dui'              => ['required', 'string', 'regex:/^\d{8}-\d{1}$/'],
            'telefono'         => ['required', 'string', 'regex:/^\d{4}-\d{4}$/'],
            'genero'           => 'required|string|in:Masculino,Femenino,Otro',
            'fecha_nacimiento' => [
                'required', 'date', 'before:today',
                function ($attribute, $value, $fail) {
                    $edad = Carbon::parse($value)->age;
                    if ($edad < 18) {
                        $fail('El voluntario debe tener al menos 18 años.');
                    }
                },
            ],
        ], [
            'dui.regex'              => 'El formato del DUI debe ser 00000000-0',
            'telefono.regex'         => 'El formato del teléfono debe ser 0000-0000',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser en el pasado',
        ]);

        $validated['user_id'] = Auth::id();
        $voluntario = Voluntario::create($validated);

        return response()->json(['message' => 'Voluntario registrado con éxito', 'voluntario' => $voluntario], 201);
    }

    public function update(Request $request, $id)
    {
        $voluntario = Voluntario::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'nombre'           => 'required|string|max:255',
            'email'            => 'nullable|email|max:255',
            'dui'              => ['required', 'string', 'regex:/^\d{8}-\d{1}$/'],
            'telefono'         => ['required', 'string', 'regex:/^\d{4}-\d{4}$/'],
            'genero'           => 'required|string|in:Masculino,Femenino,Otro',
            'fecha_nacimiento' => [
                'required', 'date', 'before:today',
                function ($attribute, $value, $fail) {
                    $edad = Carbon::parse($value)->age;
                    if ($edad < 18) {
                        $fail('El voluntario debe tener al menos 18 años.');
                    }
                },
            ],
        ], [
            'dui.regex'              => 'El formato del DUI debe ser 00000000-0',
            'telefono.regex'         => 'El formato del teléfono debe ser 0000-0000',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser en el pasado',
        ]);

        $voluntario->update($validated);

        return response()->json(['message' => 'Voluntario actualizado con éxito', 'voluntario' => $voluntario]);
    }

    public function destroy($id)
    {
        $voluntario = Voluntario::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $voluntario->delete();

        return response()->json(['message' => 'Voluntario eliminado con éxito']);
    }
}
