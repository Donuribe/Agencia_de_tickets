@extends('layouts.app')

@section('title', 'Crear Tipo de Usuario')

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

                        <form method="POST" action="{{ route('tipousuarios.store') }}" novalidate>

                            @csrf

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
                                                value="{{ old('nombre_tipo') }}"
                                            >
                                            @include('layouts.partial.field-error', ['field' => 'nombre_tipo'])

                                        </div>

                                    </div>

                                </div>

                                <input type="hidden" name="estado" value="1">

                            </div>

                            <div class="card-footer">

                                <div class="row">

                                    <div class="col-lg-2 col-xs-4">

                                        <button type="submit"
                                                class="btn btn-primary btn-block btn-flat">

                                            Registrar

                                        </button>

                                    </div>

                                    <div class="col-lg-2 col-xs-4">

                                        <a href="{{ route('tipousuarios.index') }}"
                                           class="btn btn-danger btn-block btn-flat">

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
