<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Donacion;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'icono',
    ];

    public function donaciones()
    {
        return $this->hasMany(Donacion::class);
    }
}