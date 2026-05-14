<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voluntario extends Model
{
    protected $table = 'voluntarios';

    protected $fillable = [
        'user_id',
        'nombre',
        'email',
        'dui',
        'telefono',
        'genero',
        'fecha_nacimiento'
    ];

    public function ong()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
