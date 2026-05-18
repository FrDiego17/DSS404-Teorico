<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Donacion;

class Comercio extends Model
{
    protected $fillable = [
        'user_id',
        'nombre_comercial',
        'nombre_registrado',
        'nit',
        'no_autorizacion_sanitaria',
        'telefono',
        'direccion',
        'latitud',
        'longitud',
        'horario_inicio',
        'horario_fin',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donaciones()
    {
        return $this->hasMany(Donacion::class);
    }
}