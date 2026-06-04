@extends('layouts.app')

@section('title','Listado De Usuarios')

@section('content')

<div class="content-wrapper">

    <section class="content-header" style="text-align: right;">
        <div class="container-fluid">
        </div>
    </section>

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">

                    <div class="card">

                        <div class="card-header bg-secondary"
                            style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">

                            @yield('title')

                            <a href="{{ route('usuarios.create') }}"
                               class="btn btn-primary float-right"
                               title="Nuevo">
                                <i class="fas fa-plus nav-icon"></i>
                            </a>

                        </div>

                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-hover" style="width:100%">

                                <thead class="text-primary">
                                    <tr>
                                        <th width="10px">ID</th>
                                        <th>Nombre</th>
                                        <th>Tipo de Usuario</th>
                                        <th width="120px">Estado</th>
                                        <th width="120px">Acción</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($usuarios as $usuario)

                                    <tr>

                                        <td>{{ $usuario->id }}</td>

                                        <td>
                                            {{ $usuario->name }}
                                            @if($usuario->tipoUsuario)
                                                <small class="text-muted">"{{ $usuario->tipoUsuario->nombre_tipo }}"</small>
                                            @endif
                                        </td>

                                        <td>{{ $usuario->tipoUsuario->nombre_tipo ?? 'Sin tipo' }}</td>

                                        <td>

                                            <input
                                                type="checkbox"
                                                class="toggle-class"
                                                data-id="{{ $usuario->id }}"
                                                data-toggle="toggle"
                                                data-on="Activo"
                                                data-off="Inactivo"
                                                data-onstyle="success"
                                                data-offstyle="danger"
                                                {{ $usuario->estado ? 'checked' : '' }}
                                            >

                                        </td>

                                        <td>
                                            <a href="{{ route('usuarios.show', $usuario->id) }}" class="btn btn-warning btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                               class="btn btn-warning btn-sm"
                                               title="Editar">

                                                <i class="fas fa-pencil-alt"></i>

                                            </a>

                                            <form class="d-inline delete-form"
                                                  action="{{ route('usuarios.destroy', $usuario) }}"
                                                  method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        title="Eliminar">

                                                    <i class="fas fa-trash-alt"></i>

                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>

</div>

@endsection

@push('scripts')

<script>

$(document).ready(function () {

    $('.toggle-class').bootstrapToggle();

    $('.toggle-class').change(function () {

        let estado = $(this).prop('checked') ? 1 : 0;
        let id = $(this).data('id');

        $.ajax({

            type: "GET",

            dataType: "json",

            url: "{{ route('cambioestadousuario') }}",

            data: {
                estado: estado,
                id: id
            },

            success: function (response) {

                console.log(response);

            },

            error: function (xhr) {

                console.log(xhr.responseText);

                alert('Error al cambiar el estado');

            }

        });

    });

});

</script>

@endpush


