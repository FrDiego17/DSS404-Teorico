<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'donacion_id' => 'required|exists:donaciones,id',
            'notas'       => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'donacion_id.required' => 'La donación es obligatoria',
            'donacion_id.exists'   => 'La donación seleccionada no existe',
            'notas.max'            => 'Las notas no deben superar los 500 caracteres',
        ];
    }
}