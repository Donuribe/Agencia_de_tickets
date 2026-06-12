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

        </div>
    </section>
</div>
@endsection
