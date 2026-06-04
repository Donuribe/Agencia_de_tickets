@extends('layouts.app')

@section('title', 'Editar Tipo de Usuario')

@section('content')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid"></div>
    </section>

    @include('layouts.partial.msg')
    @include('layouts.partial.form-error')

    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header bg-secondary">
                            <h3>@yield('title') #{{ $tipoUsuario->id }}</h3>
                        </div>

                        <form method="POST" action="{{ route('tipousuarios.update', $tipoUsuario) }}" novalidate>

                            @csrf
                            @method('PUT')

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">

                                        <div class="form-group">

                                            <label class="control-label">
                                                Nombre del Tipo de Usuario
                                                <strong style="color:red;">(*)</strong>
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control @error('nombre_tipo') is-invalid @enderror"
                                                name="nombre_tipo"
                                                placeholder="Ingrese el tipo de usuario"
                                                autocomplete="off"
                                                value="{{ old('nombre_tipo', $tipoUsuario->nombre_tipo) }}"
                                            >
                                            @include('layouts.partial.field-error', ['field' => 'nombre_tipo'])

                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                                        <div class="form-group">

                                            <label class="control-label">Estado</label>

                                            <select class="form-control @error('estado') is-invalid @enderror" name="estado">
                                                <option value="1" {{ old('estado', $tipoUsuario->estado) ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ ! old('estado', $tipoUsuario->estado) ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @include('layouts.partial.field-error', ['field' => 'estado'])

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="card-footer">

                                <div class="row">

                                    <div class="col-lg-2 col-xs-4">

                                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                                            Actualizar
                                        </button>

                                    </div>

                                    <div class="col-lg-2 col-xs-4">

                                        <a href="{{ route('tipousuarios.index') }}" class="btn btn-danger btn-block btn-flat">
                                            Atrás
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection
