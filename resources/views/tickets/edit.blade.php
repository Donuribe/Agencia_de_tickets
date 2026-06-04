@extends('layouts.app')

@section('title', 'Editar Ticket')

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
                            <h3>@yield('title') #{{ $ticket->id }}</h3>
                        </div>
                        <form method="POST" action="{{ route('tickets.update', $ticket) }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Título <strong style="color:red;">(*)</strong></label>
                                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" placeholder="Título del ticket" autocomplete="off" value="{{ old('titulo', $ticket->titulo) }}">
                                            @include('layouts.partial.field-error', ['field' => 'titulo'])
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Cliente <strong style="color:red;">(*)</strong></label>
                                            <select class="form-control @error('cliente_id') is-invalid @enderror" name="cliente_id">
                                                <option value="">Seleccione Cliente</option>
                                                @foreach($clientes as $cliente)
                                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $ticket->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                                        {{ $cliente->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @include('layouts.partial.field-error', ['field' => 'cliente_id'])
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Usuario Asignado</label>
                                            <select class="form-control @error('usuario_asignado_id') is-invalid @enderror" name="usuario_asignado_id">
                                                <option value="">Sin asignar</option>
                                                @foreach($usuarios as $usuario)
                                                    <option value="{{ $usuario->id }}" {{ old('usuario_asignado_id', $ticket->usuario_asignado_id) == $usuario->id ? 'selected' : '' }}>
                                                        {{ $usuario->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @include('layouts.partial.field-error', ['field' => 'usuario_asignado_id'])
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Estado</label>
                                            <select class="form-control @error('estado') is-invalid @enderror" name="estado">
                                                <option value="1" {{ old('estado', $ticket->estado) ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ ! old('estado', $ticket->estado) ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @include('layouts.partial.field-error', ['field' => 'estado'])
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Descripción <strong style="color:red;">(*)</strong></label>
                                            <textarea class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" rows="4" placeholder="Descripción del ticket">{{ old('descripcion', $ticket->descripcion) }}</textarea>
                                            @include('layouts.partial.field-error', ['field' => 'descripcion'])
                                        </div>
                                    </div>

                                    {{-- CAPTURA DEL PROBLEMA --}}
                                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                <i class="fas fa-image mr-1"></i> Captura del problema
                                                <small class="text-muted">(opcional — JPG, PNG, GIF, WEBP · máx. 5MB)</small>
                                            </label>

                                            {{-- Imagen actual --}}
                                            @if($ticket->imagen)
                                            @php $imgPath = storage_path('app/public/uploads/tickets/' . $ticket->imagen); @endphp
                                            @if(file_exists($imgPath))
                                            <div id="currentImageContainer" class="mb-2">
                                                <p class="mb-1 text-muted" style="font-size:0.85rem;">Imagen actual:</p>
                                                <img src="{{ asset('storage/uploads/tickets/' . $ticket->imagen) }}"
                                                     alt="Captura del ticket"
                                                     style="max-height:200px; max-width:100%; border-radius:6px; border:1px solid #dee2e6;">
                                                <br>
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" name="eliminar_imagen" id="eliminarImagen" value="1">
                                                    <label class="form-check-label text-danger" for="eliminarImagen">
                                                        <i class="fas fa-trash-alt mr-1"></i> Eliminar imagen actual
                                                    </label>
                                                </div>
                                            </div>
                                            @endif
                                            @endif

                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file"
                                                           class="custom-file-input @error('imagen') is-invalid @enderror"
                                                           id="imagenInput"
                                                           name="imagen"
                                                           accept="image/jpeg,image/png,image/gif,image/webp">
                                                    <label class="custom-file-label" for="imagenInput">
                                                        {{ $ticket->imagen ? 'Reemplazar imagen...' : 'Seleccionar imagen...' }}
                                                    </label>
                                                </div>
                                            </div>
                                            @error('imagen')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                            <div id="previewContainer" class="mt-2" style="display:none;">
                                                <p class="mb-1 text-muted" style="font-size:0.85rem;">Nueva imagen:</p>
                                                <img id="previewImg" src="" alt="Vista previa"
                                                     style="max-height:200px; max-width:100%; border-radius:6px; border:1px solid #dee2e6;">
                                                <br>
                                                <button type="button" class="btn btn-sm btn-danger mt-1" id="removeImagen">
                                                    <i class="fas fa-times mr-1"></i> Quitar selección
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-2 col-xs-4">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Actualizar</button>
                                    </div>
                                    <div class="col-lg-2 col-xs-4">
                                        <a href="{{ route('tickets.index') }}" class="btn btn-danger btn-block btn-flat">Atrás</a>
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

@push('scripts')
<script>
    document.getElementById('imagenInput').addEventListener('change', function () {
        const file = this.files[0];
        const label = this.nextElementSibling;
        const preview = document.getElementById('previewImg');
        const container = document.getElementById('previewContainer');

        if (file) {
            label.textContent = file.name;
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                container.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('removeImagen').addEventListener('click', function () {
        const input = document.getElementById('imagenInput');
        input.value = '';
        input.nextElementSibling.textContent = '{{ $ticket->imagen ? "Reemplazar imagen..." : "Seleccionar imagen..." }}';
        document.getElementById('previewContainer').style.display = 'none';
        document.getElementById('previewImg').src = '';
    });
</script>
@endpush
