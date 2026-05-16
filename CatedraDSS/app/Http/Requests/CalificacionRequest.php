<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalificacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'entrega_id' => 'required|exists:entregas,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'entrega_id.required' => 'La entrega es obligatoria',
            'entrega_id.exists'   => 'La entrega seleccionada no existe',
            'puntuacion.required' => 'La puntuación es obligatoria',
            'puntuacion.min'      => 'La puntuación mínima es 1',
            'puntuacion.max'      => 'La puntuación máxima es 5',
            'comentario.max'      => 'El comentario no debe superar los 500 caracteres',
        ];
    }
}