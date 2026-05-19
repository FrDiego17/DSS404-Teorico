<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'organizacion_id',
        'nombre_documento',
        'ruta_archivo',
        'tipo',
    ];

    public function organizacion()
    {
        return $this->belongsTo(Organizacion::class);
    }
}