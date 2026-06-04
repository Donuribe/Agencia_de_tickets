@extends('layouts.app')

@section('title','Ver Datos Del Cliente')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    @include('layouts.partial.msg')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary" style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nombre</label>
                                        <p>{{ $cliente->nombre }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Teléfono</label>
                                        <p>{{ $cliente->telefono }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Correo</label>
                                        <p>{{ $cliente->email }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Estado</label>
                                        <p>
                                            <span class="badge {{ $cliente->estado ? 'badge-success' : 'badge-danger' }}">
                                                {{ $cliente->estado ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Dirección</label>
                                        <p>{{ $cliente->direccion }}</p>
                                    </div>
                                </div>
                            </div>

                            @if($cliente->tickets->count())
                            <hr>
                            <h5>Tickets ({{ $cliente->tickets->count() }})</h5>
                            <div class="row">
                                @foreach($cliente->tickets as $ticket)
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Ticket #{{ $ticket->id }}</label>
                                        <p>{{ $ticket->titulo }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2 col-xs-4">
                                    <a href="{{ route('clientes.index') }}" class="btn btn-danger btn-block btn-flat">Atrás</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
