<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = [
        'entrega_id',
        'puntuacion',
        'comentario',
    ];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class);
    }
}