<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador inicial
        User::create([
            'email'    => 'admin@foodshare.com',
            'password' => Hash::make('admin123'),
            'rol'      => 'admin',
            'estado'   => 'activo',
        ]);
    }
}