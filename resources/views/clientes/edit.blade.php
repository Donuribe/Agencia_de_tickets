@extends('layouts.app')

@section('title', 'Editar Cliente')

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
                            <h3>@yield('title') #{{ $cliente->id }}</h3>
                        </div>

                        <form method="POST" action="{{ route('clientes.update', $cliente) }}" novalidate>

                            @csrf
                            @method('PUT')

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
                                                class="form-control @error('nombre') is-invalid @enderror"
                                                name="nombre"
                                                placeholder="Ingrese el nombre"
                                                autocomplete="off"
                                                value="{{ old('nombre', $cliente->nombre) }}"
                                            >
                                            @include('layouts.partial.field-error', ['field' => 'nombre'])

                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">

                                            <label>
                                                Teléfono
                                                <strong style="color:red;">(*)</strong>
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control @error('telefono') is-invalid @enderror"
                                                name="telefono"
                                                placeholder="Ingrese el teléfono"
                                                autocomplete="off"
                                                value="{{ old('telefono', $cliente->telefono) }}"
                                            >
                                            @include('layouts.partial.field-error', ['field' => 'telefono'])

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
                                                class="form-control @error('email') is-invalid @enderror"
                                                name="email"
                                                placeholder="Ingrese el correo"
                                                autocomplete="off"
                                                value="{{ old('email', $cliente->email) }}"
                                            >
                                            @include('layouts.partial.field-error', ['field' => 'email'])

                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">

                                            <label>
                                                Dirección
                                                <strong style="color:red;">(*)</strong>
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control @error('direccion') is-invalid @enderror"
                                                name="direccion"
                                                placeholder="Ingrese la dirección"
                                                autocomplete="off"
                                                value="{{ old('direccion', $cliente->direccion) }}"
                                            >
                                            @include('layouts.partial.field-error', ['field' => 'direccion'])

                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">

                                            <label>Estado</label>

                                            <select class="form-control @error('estado') is-invalid @enderror" name="estado">
                                                <option value="1" {{ old('estado', $cliente->estado) == '1' || old('estado', $cliente->estado) == 1 ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ old('estado', $cliente->estado) == '0' || old('estado', $cliente->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @include('layouts.partial.field-error', ['field' => 'estado'])

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="card-footer">

                                <div class="row">

                                    <div class="col-lg-2">

                                        <button type="submit" class="btn btn-primary btn-block">
                                            Actualizar
                                        </button>

                                    </div>

                                    <div class="col-lg-2">

                                        <a href="{{ route('clientes.index') }}" class="btn btn-danger btn-block">
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
