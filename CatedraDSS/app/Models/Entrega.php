<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $table = 'entregas';

    protected $fillable = [
        'reserva_id',
        'fecha_entrega',
        'codigo_verificacion',
        'comentarios_entrega',
    ];

    protected $casts = [
        'fecha_entrega' => 'datetime',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function calificacion()
    {
        return $this->hasOne(Calificacion::class);
    }
}