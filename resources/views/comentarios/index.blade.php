@extends('layouts.app')

@section('title','Listado De Comentarios')

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
							<a href="{{ route('comentarios.exportExcel', 'all') }}" class="btn btn-success float-right mr-2" title="Descargar Excel"><i class="fas fa-file-excel"></i></a>
							<a href="{{ route('comentarios.create') }}" class="btn btn-primary float-right mr-2" title="Nuevo"><i class="fas fa-plus nav-icon"></i></a>
						</div>
						<div class="card-body">
							<table id="example1" class="table table-bordered table-hover" style="width:100%">
								<thead class="text-primary">
									<th width="10px">ID</th>
									<th>Mensaje</th>
									<th>Ticket</th>
									<th>Usuario</th>
									<th>Fecha</th>
									<th width="60px">Estado</th>
									<th width="90px">Acción</th>
                                </thead>
                                <tbody>
									@foreach($comentarios as $comentario)
<tr>
    <td>{{ $comentario->id }}</td>
    <td>{{ \Illuminate\Support\Str::limit($comentario->mensaje, 50) }}</td>

    <td>{{ $comentario->ticket->titulo ?? 'N/A' }}</td>

    {{-- 🔥 AQUÍ ESTÁ EL FIX --}}
    <td>
        {{ $comentario->usuario->name ?? 'N/A' }}
        @if($comentario->usuario?->tipoUsuario)
            <br><small class="text-muted">"{{ $comentario->usuario->tipoUsuario->nombre_tipo }}"</small>
        @endif
    </td>

    <td>{{ $comentario->fecha }}</td>

    <td>
        <input data-type="comentario" data-id="{{$comentario->id}}"
        class="toggle-class" type="checkbox"
        data-onstyle="success" data-offstyle="danger"
        data-toggle="toggle" data-on="Activo" data-off="Inactivo"
        {{ $comentario->estado ? 'checked' : '' }}>
    </td>

					<td>
        <a href="{{ route('comentarios.show', $comentario->id) }}"
        class="btn btn-warning btn-sm" title="Ver">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('comentarios.edit', $comentario->id) }}"
        class="btn btn-warning btn-sm" title="Editar">
            <i class="fas fa-pencil-alt"></i>
        </a>

        <form class="d-inline delete-form"
        action="{{ route('comentarios.destroy', $comentario) }}"
        method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
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
