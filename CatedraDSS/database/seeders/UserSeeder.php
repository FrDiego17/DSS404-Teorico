<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Comercio;
use App\Models\Organizacion;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Administrador
        User::firstOrCreate(
            ['email' => 'admin@foodshare.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('admin123'),
                'rol'      => 'admin',
                'estado'   => 'activo',
            ]
        );

        // 2. ONG activa —
        $userOng = User::firstOrCreate(
            ['email' => 'ong1@foodshare.com'],
            [
                'name'     => 'Fundación Esperanza',
                'password' => Hash::make('ong12345'),
                'rol'      => 'organizacion',
                'estado'   => 'activo',
            ]
        );

        Organizacion::firstOrCreate(
            ['user_id' => $userOng->id],
            [
                'nombre_oficial'      => 'Fundación Esperanza',
                'numero_registro'     => 'REG-001',
                'representante_legal' => 'Juan López',
                'telefono_contacto'   => '7100-0001',
                'direccion'           => 'San Salvador, El Salvador',
                'estado_verificacion' => 'verificada',
            ]
        );

        // 3. ONG pendiente
        $userOng2 = User::firstOrCreate(
            ['email' => 'ong2@foodshare.com'],
            [
                'name'     => 'Manos Solidarias',
                'password' => Hash::make('ong12345'),
                'rol'      => 'organizacion',
                'estado'   => 'pendiente',
            ]
        );

        Organizacion::firstOrCreate(
            ['user_id' => $userOng2->id],
            [
                'nombre_oficial'      => 'Manos Solidarias',
                'numero_registro'     => 'REG-002',
                'representante_legal' => 'María García',
                'telefono_contacto'   => '7200-0002',
                'direccion'           => 'Santa Ana, El Salvador',
                'estado_verificacion' => 'pendiente',
            ]
        );

        // 4. Comercio 
        $userComercio = User::firstOrCreate(
            ['email' => 'comercio@foodshare.com'],
            [
                'name'     => 'Restaurante El Buen Sabor',
                'password' => Hash::make('comercio123'),
                'rol'      => 'comercio',
                'estado'   => 'activo',
            ]
        );

        Comercio::firstOrCreate(
            ['user_id' => $userComercio->id],
            [
                'nombre_comercial'          => 'Restaurante El Buen Sabor',
                'nombre_registrado'         => 'El Buen Sabor S.A. de C.V.',
                'nit'                       => '0614-010101-101-1',
                'no_autorizacion_sanitaria' => 'SAN-2024-001',
                'telefono'                  => '2200-0000',
                'direccion'                 => 'Col. Escalón, San Salvador',
                'estado'                    => 'aprobado',
            ]
        );

    }
}