<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Platos Preparados',     'icono' => null],
            ['nombre' => 'Panaderia y Reposteria', 'icono' => null],
            ['nombre' => 'Frutas y Verduras',      'icono' => null],
            ['nombre' => 'Bebidas y Jugos',        'icono' => null],
            ['nombre' => 'Lacteos',                'icono' => null],
            ['nombre' => 'Granos y Cereales',      'icono' => null],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}