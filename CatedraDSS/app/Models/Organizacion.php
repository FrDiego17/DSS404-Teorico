<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizacion extends Model
{
    protected $table = 'organizaciones';

    protected $fillable = [
        'user_id',
        'nombre_oficial',
        'numero_registro',
        'representante_legal',
        'mision',
        'telefono_contacto',
        'direccion',
        'estado_verificacion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}