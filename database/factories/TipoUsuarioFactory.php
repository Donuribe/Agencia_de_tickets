<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TipoUsuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoUsuario>
 */
class TipoUsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_tipo' => $this->faker->randomElement(['Admin', 'Usuario', 'Moderador', 'Cliente']),
            'estado' => 1,
            'registrado_por' => $this->faker->name(),
        ];
    }
}