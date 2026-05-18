<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterOrganizacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_oficial'      => 'required|string|max:255',
            'numero_registro'     => 'required|string|max:50|unique:organizaciones,numero_registro',
            'representante_legal' => 'required|string|max:255',
            'telefono_contacto'   => 'required|string|max:20',
            'direccion'           => 'required|string|max:255',
            'mision'              => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_oficial.required'      => 'El nombre oficial es obligatorio',
            'numero_registro.required'     => 'El número de registro es obligatorio',
            'numero_registro.unique'       => 'Este número de registro ya está registrado',
            'representante_legal.required' => 'El representante legal es obligatorio',
            'telefono_contacto.required'   => 'El teléfono de contacto es obligatorio',
            'direccion.required'           => 'La dirección es obligatoria',
        ];
    }
}