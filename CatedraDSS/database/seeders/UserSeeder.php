<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuario administrador (id = 1)
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@foodshare.com',
            'password' => Hash::make('admin123'),
            'rol'      => 'admin',
            'estado'   => 'activo',
        ]);

        // 2. Usuario ONG - Fundación Esperanza (Hecho para el seeder de ONG <3)
        User::create([
            'name'     => 'Fundación Esperanza',
            'email'    => 'ong1@foodshare.com',
            'password' => Hash::make('ong12345'),
            'rol'      => 'organizacion',
            'estado'   => 'activo',
        ]);

        // 3. Usuario ONG - Manos Solidarias (Hecho para el seeder de ONG <3)
        User::create([
            'name'     => 'Manos Solidarias',
            'email'    => 'ong2@foodshare.com',
            'password' => Hash::make('ong12345'),
            'rol'      => 'organizacion',
            'estado'   => 'pendiente',
        ]);

        // 4. Usuario ONG - Ayuda Comunitaria (Hecho para el seeder de ONG <3)
        User::create([
            'name'     => 'Ayuda Comunitaria',
            'email'    => 'ong3@foodshare.com',
            'password' => Hash::make('ong12345'),
            'rol'      => 'organizacion',
            'estado'   => 'inactivo',
        ]);
    }
}