@extends('layouts.app')

@section('title','Ver Tipo De Usuario')

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
                                        <label class="control-label">Nombre del Tipo</label>
                                        <p>{{ $tipoUsuario->nombre_tipo }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Estado</label>
                                        <p>
                                            <span class="badge {{ $tipoUsuario->estado ? 'badge-success' : 'badge-danger' }}">
                                                {{ $tipoUsuario->estado ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if($tipoUsuario->usuarios->count())
                            <hr>
                            <h5>Usuarios asociados ({{ $tipoUsuario->usuarios->count() }})</h5>
                            <div class="row">
                                @foreach($tipoUsuario->usuarios as $usuario)
                                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                    <div class="form-group label-floating">
                                        <p>{{ $usuario->name }} ({{ $usuario->email }})</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2 col-xs-4">
                                    <a href="{{ route('tipousuarios.index') }}" class="btn btn-danger btn-block btn-flat">Atrás</a>
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
