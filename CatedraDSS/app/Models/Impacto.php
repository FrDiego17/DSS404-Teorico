<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Impacto extends Model
{
    use SoftDeletes;

    protected $table = 'impactos';

    protected $fillable = [
        'organizacion_id',
        'titulo',
        'descripcion',
        'imagen'
    ];

    public function organizacion()
    {
        return $this->belongsTo(Organizacion::class, 'organizacion_id');
    }
}