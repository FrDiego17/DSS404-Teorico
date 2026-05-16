<?php

namespace Database\Factories;

use App\Models\Organizacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizacionFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected $model = Organizacion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Esto crea un usuario automáticamente al probar OwO
            'nombre_oficial' => fake()->company(),
            'numero_registro' => fake()->unique()->numerify('ONG-#####'),
            'representante_legal' => fake()->name(),
            'mision' => fake()->sentence(10),
            'telefono_contacto' => fake()->phoneNumber(),
            'direccion' => fake()->address(),
            'estado_verificacion' => fake()->randomElement(['pendiente', 'verificada', 'rechazada']),
        ];
    }
}