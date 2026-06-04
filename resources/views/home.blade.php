@extends('layouts.app')

@section('title','Panel De Control')

@section('content')
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1 class="m-0">Panel De Control</h1>
                    <small class="text-muted">
                        Bienvenido, <strong>{{ Auth::user()->name }}</strong>
                        @if(Auth::user()->tipoUsuario)
                            &mdash; <span class="text-secondary">"{{ Auth::user()->tipoUsuario->nombre_tipo }}"</span>
                        @endif
                    </small>
                </div>
                <div class="col-sm-4 text-right">
                    <small class="text-muted">{{ now()->format('d/m/Y H:i') }}</small>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- ── FILA 1: Tarjetas principales ── --}}
            <div class="row">

                {{-- Clientes --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalClientes }}</h3>
                            <p>Clientes registrados</p>
                        </div>
                        <div class="icon"><i class="fas fa-handshake"></i></div>
                        <a href="{{ route('clientes.index') }}" class="small-box-footer">
                            Ver clientes <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Tickets abiertos --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $ticketsAbiertos }}</h3>
                            <p>Tickets abiertos</p>
                        </div>
                        <div class="icon"><i class="fas fa-ticket-alt"></i></div>
                        <a href="{{ route('tickets.index') }}" class="small-box-footer">
                            Ver tickets <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Tickets cerrados --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $ticketsCerrados }}</h3>
                            <p>Tickets cerrados</p>
                        </div>
                        <div class="icon"><i class="fas fa-check-circle"></i></div>
                        <a href="{{ route('tickets.index') }}" class="small-box-footer">
                            Ver tickets <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Usuarios --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalUsuarios }}</h3>
                            <p>Usuarios del sistema</p>
                        </div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                        <a href="{{ route('usuarios.index') }}" class="small-box-footer">
                            Ver usuarios <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

            </div>

            {{-- ── FILA 2: Estadísticas secundarias ── --}}
            <div class="row">

                {{-- Clientes activos --}}
                <div class="col-lg-3 col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-user-check"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Clientes activos</span>
                            <span class="info-box-number">{{ $clientesActivos }}</span>
                            <div class="progress">
                                <div class="progress-bar bg-info" style="width: {{ $totalClientes > 0 ? round($clientesActivos / $totalClientes * 100) : 0 }}%"></div>
                            </div>
                            <span class="progress-description">
                                {{ $totalClientes > 0 ? round($clientesActivos / $totalClientes * 100) : 0 }}% del total
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Usuarios activos --}}
                <div class="col-lg-3 col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fas fa-user-cog"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Usuarios activos</span>
                            <span class="info-box-number">{{ $usuariosActivos }}</span>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: {{ $totalUsuarios > 0 ? round($usuariosActivos / $totalUsuarios * 100) : 0 }}%"></div>
                            </div>
                            <span class="progress-description">
                                {{ $totalUsuarios > 0 ? round($usuariosActivos / $totalUsuarios * 100) : 0 }}% del total
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Total tickets --}}
                <div class="col-lg-3 col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1">
                            <i class="fas fa-clipboard-list"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total tickets</span>
                            <span class="info-box-number">{{ $totalTickets }}</span>
                            <div class="progress">
                                <div class="progress-bar bg-warning"
                                     style="width: {{ $totalTickets > 0 ? round($ticketsAbiertos / $totalTickets * 100) : 0 }}%"></div>
                            </div>
                            <span class="progress-description">
                                {{ $totalTickets > 0 ? round($ticketsAbiertos / $totalTickets * 100) : 0 }}% abiertos
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Comentarios --}}
                <div class="col-lg-3 col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1">
                            <i class="fas fa-comments"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Comentarios totales</span>
                            <span class="info-box-number">{{ $totalComentarios }}</span>
                            <div class="progress">
                                <div class="progress-bar bg-danger" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">En todos los tickets</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── FILA 3: Tablas y listas ── --}}
            <div class="row">

                {{-- Tickets recientes --}}
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-ticket-alt mr-2"></i>Tickets Recientes
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-primary">
                                    Ver todos
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="40">#</th>
                                        <th>Título</th>
                                        <th>Cliente</th>
                                        <th>Asignado a</th>
                                        <th width="80">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ticketsRecientes as $ticket)
                                    <tr>
                                        <td>{{ $ticket->id }}</td>
                                        <td>
                                            <a href="{{ route('tickets.show', $ticket->id) }}">
                                                {{ \Illuminate\Support\Str::limit($ticket->titulo, 35) }}
                                            </a>
                                        </td>
                                        <td>{{ $ticket->cliente->nombre ?? 'N/A' }}</td>
                                        <td>
                                            {{ $ticket->usuarioAsignado->name ?? 'Sin asignar' }}
                                            @if($ticket->usuarioAsignado?->tipoUsuario)
                                                <br><small class="text-muted">"{{ $ticket->usuarioAsignado->tipoUsuario->nombre_tipo }}"</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $ticket->estado ? 'badge-success' : 'badge-danger' }}">
                                                {{ $ticket->estado ? 'Abierto' : 'Cerrado' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">No hay tickets registrados</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Panel derecho --}}
                <div class="col-lg-4">

                    {{-- Usuarios por tipo --}}
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-user-tag mr-2"></i>Usuarios por Tipo
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse($usuariosPorTipo as $tipo)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-circle mr-2 text-primary" style="font-size:0.6rem;"></i>{{ $tipo->nombre_tipo }}</span>
                                    <span class="badge badge-primary badge-pill">{{ $tipo->usuarios_count }}</span>
                                </li>
                                @empty
                                <li class="list-group-item text-muted text-center">Sin tipos registrados</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="card-footer text-right py-2">
                            <a href="{{ route('tipousuarios.index') }}" class="text-sm text-primary">
                                Gestionar tipos <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Comentarios recientes --}}
                    <div class="card mt-0">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-comments mr-2"></i>Últimos Comentarios
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse($comentariosRecientes as $com)
                                <li class="list-group-item py-2">
                                    <div class="d-flex justify-content-between">
                                        <strong style="font-size:0.85rem;">
                                            {{ $com->usuario->name ?? 'N/A' }}
                                            @if($com->usuario?->tipoUsuario)
                                                <small class="text-muted">"{{ $com->usuario->tipoUsuario->nombre_tipo }}"</small>
                                            @endif
                                        </strong>
                                        <small class="text-muted">Ticket #{{ $com->ticket_id }}</small>
                                    </div>
                                    <p class="mb-0 text-muted" style="font-size:0.8rem;">
                                        {{ \Illuminate\Support\Str::limit($com->mensaje, 60) }}
                                    </p>
                                </li>
                                @empty
                                <li class="list-group-item text-muted text-center">Sin comentarios</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="card-footer text-right py-2">
                            <a href="{{ route('comentarios.index') }}" class="text-sm text-primary">
                                Ver todos <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
            {{-- ── FIN FILA 3 ── --}}

        </div>
    </section>
</div>
@endsection
