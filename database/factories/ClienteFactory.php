<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->phoneNumber(),
            'estado' => 1,
            'registradopor' => $this->faker->name(), // 🔥 ESTE ERA EL QUE FALTABA
        ];
    }
}
