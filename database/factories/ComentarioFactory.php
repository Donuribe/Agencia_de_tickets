<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comentario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentario>
 */
class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
    'fecha' => $this->faker->dateTimeBetween('-1 year', 'now'),
    'registrado_por' => $this->faker->name(),
    'mensaje' => $this->faker->sentence(),
    'estado' => 1,
    'ticket_id' => \App\Models\Ticket::pluck('id')->random(),
    'usuario_id' => \App\Models\User::pluck('id')->random(), // ✅ SOLO ESTE
];
    }
}
