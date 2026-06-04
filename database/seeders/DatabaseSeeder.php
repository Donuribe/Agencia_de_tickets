<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Ticket;
use App\Models\Comentario;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🔥 Crear usuarios
        $users = User::factory(10)->create();

        // 🔥 Crear clientes
        Cliente::factory(20)->create();

        // 🔥 Crear tickets asociados a usuarios
        $tickets = [];

        foreach ($users as $user) {
            $userTickets = Ticket::factory(3)->create([
                'user_id' => $user->id
            ]);

            $tickets = array_merge($tickets, $userTickets->all());
        }

        // 🔥 Crear comentarios asociados a tickets
        foreach ($tickets as $ticket) {
            Comentario::factory(2)->create([
                'ticket_id' => $ticket->id,
                'usuario_id' => $users->random()->id, // 👈 IMPORTANTE
                'fecha' => now(),
                'estado' => 1
            ]);
        }
    }
}
