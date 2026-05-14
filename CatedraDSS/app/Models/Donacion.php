<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donacion extends Model
{
    protected $table = 'donaciones';

    protected $fillable = [
        'comercio_id',
        'categoria_id',
        'titulo',
        'descripcion',
        'cantidad',
        'peso_estimado_kg',
        'fecha_limite',
        'estado',
    ];

    protected $casts = [
        'fecha_limite' => 'datetime',
    ];

    public function comercio()
    {
        return $this->belongsTo(Comercio::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
