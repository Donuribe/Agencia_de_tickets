@extends('layouts.app')

@section('title', 'Crear Usuario')

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
                            <h3>@yield('title')</h3>
                        </div>

                        <form method="POST" action="{{ route('usuarios.store') }}" novalidate>

                            @csrf

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-6">

                                        <div class="form-group">

                                            <label>
                                                Nombre
                                                <strong style="color:red;">(*)</strong>
                                            </label>

                                            <input
                                                type="text"
                                                name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Ingrese el nombre"
                                                value="{{ old('name') }}"
                                            >
                                            @include('layouts.partial.field-error', ['field' => 'name'])

                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">

                                            <label>
                                                Correo
                                                <strong style="color:red;">(*)</strong>
                                            </label>

                                            <input
                                                type="email"
                                                name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Ingrese el correo"
                                                value="{{ old('email') }}"
                                            >
                                            @include('layouts.partial.field-error', ['field' => 'email'])

                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">

                                            <label>
                                                Contraseña
                                                <strong style="color:red;">(*)</strong>
                                            </label>

                                            <input
                                                type="password"
                                                name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                            >
                                            @include('layouts.partial.field-error', ['field' => 'password'])

                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">

                                            <label>
                                                Tipo de Usuario
                                                <strong style="color:red;">(*)</strong>
                                            </label>

                                            <select
                                                name="tipo_usuario_id"
                                                class="form-control @error('tipo_usuario_id') is-invalid @enderror"
                                            >

                                                <option value="">
                                                    Seleccione
                                                </option>

                                                @foreach($tipoUsuarios as $tipo)

                                                    <option
                                                        value="{{ $tipo->id }}"
                                                        {{ old('tipo_usuario_id') == $tipo->id ? 'selected' : '' }}>

                                                        {{ $tipo->nombre_tipo }}

                                                    </option>

                                                @endforeach

                                            </select>
                                            @include('layouts.partial.field-error', ['field' => 'tipo_usuario_id'])

                                        </div>

                                    </div>

                                </div>

                                <input type="hidden" name="estado" value="1">

                            </div>

                            <div class="card-footer">

                                <div class="row">

                                    <div class="col-lg-2">

                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-block">

                                            Registrar

                                        </button>

                                    </div>

                                    <div class="col-lg-2">

                                        <a href="{{ route('usuarios.index') }}"
                                           class="btn btn-danger btn-block">

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
