<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Comentario;
use App\Models\Ticket;
use App\Models\TipoUsuario;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // ── Tarjetas principales ──────────────────────────────────────
        $totalClientes    = Cliente::count();
        $clientesActivos  = Cliente::where('estado', 1)->count();

        $totalTickets     = Ticket::count();
        $ticketsAbiertos  = Ticket::where('estado', 1)->count();
        $ticketsCerrados  = Ticket::where('estado', 0)->count();

        $totalUsuarios    = User::count();
        $usuariosActivos  = User::where('estado', 1)->count();

        $totalComentarios = Comentario::count();

        // ── Tickets recientes (últimos 5) ─────────────────────────────
        $ticketsRecientes = Ticket::with(['cliente', 'usuarioAsignado'])
            ->latest()
            ->take(5)
            ->get();

        // ── Distribución de tickets por estado ───────────────────────
        $ticketsPorEstado = [
            'Abiertos'  => $ticketsAbiertos,
            'Cerrados'  => $ticketsCerrados,
        ];

        // ── Usuarios por tipo ─────────────────────────────────────────
        $usuariosPorTipo = TipoUsuario::withCount('usuarios')
            ->where('estado', 1)
            ->get();

        // ── Últimos comentarios ───────────────────────────────────────
        $comentariosRecientes = Comentario::with(['ticket', 'usuario'])
            ->latest()
            ->take(5)
            ->get();

        return view('home', compact(
            'totalClientes',
            'clientesActivos',
            'totalTickets',
            'ticketsAbiertos',
            'ticketsCerrados',
            'totalUsuarios',
            'usuariosActivos',
            'totalComentarios',
            'ticketsRecientes',
            'ticketsPorEstado',
            'usuariosPorTipo',
            'comentariosRecientes',
        ));
    }
}
