<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubirDocumentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'documento' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'tipo'      => 'required|in:pdf,imagen,otro',
        ];
    }

    public function messages(): array
    {
        return [
            'documento.required' => 'El archivo es obligatorio',
            'documento.file'     => 'El archivo debe ser un documento válido',
            'documento.mimes'    => 'Solo se permiten archivos PDF, JPG, JPEG o PNG',
            'documento.max'      => 'El archivo no debe superar los 5MB',
            'tipo.required'      => 'El tipo de documento es obligatorio',
            'tipo.in'            => 'El tipo debe ser pdf, imagen u otro',
        ];
    }
}