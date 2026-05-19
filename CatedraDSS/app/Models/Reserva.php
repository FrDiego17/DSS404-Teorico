<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'donacion_id',
        'organizacion_id',
        'fecha_reserva',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha_reserva' => 'datetime',
    ];

    public function donacion()
    {
        return $this->belongsTo(Donacion::class);
    }

    public function organizacion()
    {
        return $this->belongsTo(Organizacion::class);
    }

    public function entrega()
    {
        return $this->hasOne(Entrega::class);
    }
}