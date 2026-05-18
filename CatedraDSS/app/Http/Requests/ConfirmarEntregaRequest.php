<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmarEntregaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reserva_id'          => 'required|exists:reservas,id',
            'codigo_verificacion' => 'required|string|max:50',
            'comentarios_entrega' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'reserva_id.required'          => 'La reserva es obligatoria',
            'reserva_id.exists'            => 'La reserva seleccionada no existe',
            'codigo_verificacion.required' => 'El código de verificación es obligatorio',
            'codigo_verificacion.max'      => 'El código no debe superar los 50 caracteres',
            'comentarios_entrega.max'      => 'Los comentarios no deben superar los 500 caracteres',
        ];
    }
}