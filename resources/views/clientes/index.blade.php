@extends('layouts.app')

@section('title','Listado De Clientes')

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
                        <div class="card-header bg-secondary" style="font-size: 1.75rem;font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')
                            <a href="{{ route('clientes.selectPdf') }}" class="btn btn-info float-right" title="Descargar PDF"><i class="fas fa-file-pdf"></i></a>
                            <a href="{{ route('clientes.exportExcel', 'all') }}" class="btn btn-success float-right mr-2" title="Descargar Excel"><i class="fas fa-file-excel"></i></a>
                            <a href="{{ route('clientes.create') }}" class="btn btn-primary float-right mr-2" title="Nuevo"><i class="fas fa-plus nav-icon"></i></a>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover" style="width:100%">
                                <thead class="text-primary">
                                    <th width="10px">ID</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th width="80px">Foto</th>
                                    <th width="60px">Estado</th>
                                    <th width="120px">Acción</th>
                                </thead>
                                <tbody>
                                    @foreach($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente->id }}</td>
                                        <td>{{ $cliente->nombre }}</td>
                                        <td>{{ $cliente->direccion }}</td>
                                        <td>{{ $cliente->telefono }}</td>
                                        <td>
                                            @if($cliente->foto)
                                                <img src="{{ asset($cliente->foto) }}" alt="{{ $cliente->nombre }}" style="max-width: 60px; max-height: 60px;" class="img-thumbnail">
                                            @else
                                                <img src="{{ asset('/backend/dist/img/default-150x150.png') }}" alt="Sin foto" style="max-width: 60px; max-height: 60px;" class="img-thumbnail">
                                            @endif
                                        </td>
                                        <td>
                                            <input data-type="cliente" data-id="{{$cliente->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger"
                                            data-toggle="toggle" data-on="Activo" data-off="Inactivo" {{ $cliente->estado ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-warning btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                            <form class="d-inline delete-form" action="{{ route('clientes.destroy', $cliente) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
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
