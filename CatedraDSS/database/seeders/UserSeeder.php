<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuario administrador
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@foodshare.com',
            'password' => Hash::make('admin123'),
            'rol'      => 'admin',
            'estado'   => 'activo',
        ]);

        // 2. Usuario ONG 
        User::create([
            'name'     => 'Fundación Esperanza',
            'email'    => 'ong1@foodshare.com',
            'password' => Hash::make('ong12345'),
            'rol'      => 'organizacion',
            'estado'   => 'activo',
        ]);

        // 3. Comercio 
        User::create([
            'name'     => 'Manos Solidarias',
            'email'    => 'comercio@foodshare.com',
            'password' => Hash::make('comercio123'),
            'rol'      => 'comercio',
            'estado'   => 'activo',
        ]);

    }
}