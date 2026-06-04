@extends('layouts.app')

@section('title','Ver Datos Del Usuario')

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
                                        <p>
                                            {{ $usuario->name }}
                                            @if($usuario->tipoUsuario)
                                                <small class="text-muted">"{{ $usuario->tipoUsuario->nombre_tipo }}"</small>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Correo</label>
                                        <p>{{ $usuario->email }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Tipo de Usuario</label>
                                        <p>{{ $usuario->tipoUsuario->nombre_tipo ?? 'Sin tipo' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Estado</label>
                                        <p>
                                            <span class="badge {{ $usuario->estado ? 'badge-success' : 'badge-danger' }}">
                                                {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2 col-xs-4">
                                    <a href="{{ route('usuarios.index') }}" class="btn btn-danger btn-block btn-flat">Atrás</a>
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
