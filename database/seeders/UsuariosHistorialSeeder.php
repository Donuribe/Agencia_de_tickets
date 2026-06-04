<?php

namespace Database\Seeders;

use App\Models\TipoUsuario;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosHistorialSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener IDs de tipos activos
        $tipoAgente        = TipoUsuario::where('nombre_tipo', 'Agente')->where('estado', 1)->first()?->id;
        $tipoSoporte       = TipoUsuario::where('nombre_tipo', 'Soporte')->where('estado', 1)->first()?->id;
        $tipoAdministrador = TipoUsuario::where('nombre_tipo', 'Administrador')->where('estado', 1)->first()?->id;

        $usuarios = [
            ['name' => 'Carlos Mendoza',  'email' => 'carlos.mendoza@sistema.com',  'tipo' => $tipoAgente],
            ['name' => 'Laura Vásquez',   'email' => 'laura.vasquez@sistema.com',   'tipo' => $tipoSoporte],
            ['name' => 'Miguel Torres',   'email' => 'miguel.torres@sistema.com',   'tipo' => $tipoAgente],
            ['name' => 'Ana Gutiérrez',   'email' => 'ana.gutierrez@sistema.com',   'tipo' => $tipoSoporte],
            ['name' => 'Roberto Díaz',    'email' => 'roberto.diaz@sistema.com',    'tipo' => $tipoAdministrador],
            ['name' => 'Patricia Solís',  'email' => 'patricia.solis@sistema.com',  'tipo' => $tipoSoporte],
            ['name' => 'Javier Ramírez',  'email' => 'javier.ramirez@sistema.com',  'tipo' => $tipoAgente],
        ];

        foreach ($usuarios as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'            => $data['name'],
                    'password'        => Hash::make('password123'),
                    'estado'          => 1,
                    'tipo_usuario_id' => $data['tipo'],
                ]
            );
        }
    }
}
