<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organizacion;

class OrganizacionSeeder extends Seeder
{
    public function run(): void
    {
        
        // ONG verificada
        Organizacion::create([
            'user_id'             => 1,
            'nombre_oficial'      => 'Fundación Esperanza',
            'numero_registro'     => 'ONG-00001',
            'representante_legal' => 'Juan Pérez',
            'telefono_contacto'   => '2222-1111',
            'direccion'           => 'San Salvador',
            'estado_verificacion' => 'verificada',
        ]);

        // ONG pendiente
        Organizacion::create([
            'user_id'             => 2,
            'nombre_oficial'      => 'Manos Solidarias',
            'numero_registro'     => 'ONG-00002',
            'representante_legal' => 'María López',
            'telefono_contacto'   => '2222-3333',
            'direccion'           => 'Santa Ana',
            'estado_verificacion' => 'pendiente',
        ]);

        // ONG rechazada
        Organizacion::create([
            'user_id'             => 3,
            'nombre_oficial'      => 'Ayuda Comunitaria',
            'numero_registro'     => 'ONG-00003',
            'representante_legal' => 'Carlos Ramírez',
            'telefono_contacto'   => '2222-4444',
            'direccion'           => 'San Miguel',
            'estado_verificacion' => 'rechazada',
        ]);
    }
}