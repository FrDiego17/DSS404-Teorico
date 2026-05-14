<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterComercioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_comercial'          => 'required|string|max:255',
            'nombre_registrado'         => 'required|string|max:255',
            'email'                     => 'required|email|unique:users,email',
            'password'                  => 'required|string|min:6|confirmed',
            'nit'                       => 'required|string|unique:comercios,nit',
            'no_autorizacion_sanitaria' => 'required|string',
            'telefono'                  => 'nullable|string|max:20',
            'direccion'                 => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_comercial.required'          => 'El nombre comercial es obligatorio',
            'email.required'                     => 'El correo es obligatorio',
            'email.unique'                       => 'Este correo ya está registrado',
            'password.confirmed'                 => 'Las contraseñas no coinciden',
            'nit.required'                       => 'El NIT es obligatorio',
            'nit.unique'                         => 'Este NIT ya está registrado',
            'no_autorizacion_sanitaria.required' => 'El número de autorización sanitaria es obligatorio',
        ];
    }
}