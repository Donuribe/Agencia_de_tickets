@extends('layouts.app')

@section('title', 'Editar Comentario')

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
                            <h3>@yield('title') #{{ $comentario->id }}</h3>
                        </div>

                        <form method="POST" action="{{ route('comentarios.update', $comentario) }}" novalidate>

                            @csrf
                            @method('PUT')

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-lg-12">

                                        <div class="form-group">

                                            <label>
                                                Mensaje
                                                <strong style="color:red;">(*)</strong>
                                            </label>

                                            <textarea
                                                class="form-control @error('mensaje') is-invalid @enderror"
                                                name="mensaje"
                                                rows="4"
                                                placeholder="Escriba el comentario"
                                            >{{ old('mensaje', $comentario->mensaje) }}</textarea>
                                            @include('layouts.partial.field-error', ['field' => 'mensaje'])

                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">

                                            <label>
                                                Ticket
                                                <strong style="color:red;">(*)</strong>
                                            </label>

                                            <select class="form-control @error('ticket_id') is-invalid @enderror" name="ticket_id">
                                                <option value="">Seleccione Ticket</option>
                                                @foreach($tickets as $ticket)
                                                    <option value="{{ $ticket->id }}" {{ old('ticket_id', $comentario->ticket_id) == $ticket->id ? 'selected' : '' }}>
                                                        #{{ $ticket->id }} - {{ $ticket->titulo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @include('layouts.partial.field-error', ['field' => 'ticket_id'])

                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">

                                            <label>
                                                Usuario
                                                <strong style="color:red;">(*)</strong>
                                            </label>

                                            <select class="form-control @error('usuario_id') is-invalid @enderror" name="usuario_id">
                                                <option value="">Seleccione Usuario</option>
                                                @foreach($usuarios as $usuario)
                                                    <option value="{{ $usuario->id }}" {{ old('usuario_id', $comentario->usuario_id) == $usuario->id ? 'selected' : '' }}>
                                                        {{ $usuario->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @include('layouts.partial.field-error', ['field' => 'usuario_id'])

                                        </div>

                                    </div>

                                    <div class="col-lg-6">

                                        <div class="form-group">

                                            <label>Estado</label>

                                            <select class="form-control @error('estado') is-invalid @enderror" name="estado">
                                                <option value="1" {{ old('estado', $comentario->estado) == '1' || old('estado', $comentario->estado) == 1 ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ old('estado', $comentario->estado) == '0' || old('estado', $comentario->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
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

                                        <a href="{{ route('comentarios.index') }}" class="btn btn-danger btn-block">
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
