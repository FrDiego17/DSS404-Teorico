<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoria_id'     => 'required|exists:categorias,id',
            'titulo'           => 'required|string|max:255',
            'descripcion'      => 'nullable|string',
            'cantidad'         => 'required|integer|min:1',
            'peso_estimado_kg' => 'required|numeric|min:0.1',
            'fecha_limite'     => 'required|date|after:now',
        ];
    }

    public function messages(): array
    {
        return [
            'categoria_id.required'     => 'La categoría es obligatoria',
            'categoria_id.exists'       => 'La categoría seleccionada no existe',
            'titulo.required'           => 'El título es obligatorio',
            'cantidad.required'         => 'La cantidad es obligatoria',
            'cantidad.min'              => 'La cantidad debe ser al menos 1',
            'peso_estimado_kg.required' => 'El peso estimado es obligatorio',
            'peso_estimado_kg.min'      => 'El peso debe ser mayor a 0',
            'fecha_limite.required'     => 'La fecha límite es obligatoria',
            'fecha_limite.after'        => 'La fecha límite debe ser posterior a ahora',
        ];
    }
}