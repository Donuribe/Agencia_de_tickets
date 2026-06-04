<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Cliente;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence(),
            'descripcion' => $this->faker->paragraph(),
            'imagen' => $this->faker->optional()->imageUrl(),
            'estado' => 1,
            'registrado_por' => $this->faker->name(),
            'fecha_creacion' => now(),
            'fecha_cierre' => $this->faker->optional(0.3)->dateTimeBetween('now', '+1 month'),

            // 🔥 MÁS SEGURO
            'cliente_id' => Cliente::inRandomOrder()->value('id') ?? 1,
            'usuario_asignado_id' => User::inRandomOrder()->value('id') ?? 1,
            'user_id' => User::inRandomOrder()->value('id') ?? 1,
        ];
    }
}
