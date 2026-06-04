@extends('layouts.app')

@section('title','Ver Ticket')

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
                        <div class="card-header bg-secondary" style="font-size:1.75rem;font-weight:500;line-height:1.2;margin-bottom:0.5rem;">
                            @yield('title') #{{ $ticket->id }}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Título</label>
                                        <p>{{ $ticket->titulo }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Estado</label>
                                        <p>
                                            <span class="badge {{ $ticket->estado ? 'badge-success' : 'badge-danger' }}">
                                                {{ $ticket->estado ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Cliente</label>
                                        <p>{{ $ticket->cliente->nombre ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Usuario Asignado</label>
                                        <p>
                                            {{ $ticket->usuarioAsignado->name ?? 'Sin asignar' }}
                                            @if($ticket->usuarioAsignado?->tipoUsuario)
                                                <small class="text-muted">"{{ $ticket->usuarioAsignado->tipoUsuario->nombre_tipo }}"</small>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Fecha de Creación</label>
                                        <p>{{ $ticket->fecha_creacion ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Fecha de Cierre</label>
                                        <p>{{ $ticket->fecha_cierre ?? 'Sin cerrar' }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Descripción</label>
                                        <p>{{ $ticket->descripcion ?? 'Sin descripción' }}</p>
                                    </div>
                                </div>

                                @if($ticket->imagen)
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            <i class="fas fa-image mr-1"></i> Captura del problema
                                        </label>
                                        <div>
                                            @php
                                                $imgPath = storage_path('app/public/uploads/tickets/' . $ticket->imagen);
                                                $imgUrl  = asset('storage/uploads/tickets/' . $ticket->imagen);
                                            @endphp
                                            @if(file_exists($imgPath))
                                                <a href="{{ $imgUrl }}" target="_blank" title="Ver imagen completa">
                                                    <img src="{{ $imgUrl }}"
                                                         alt="Captura del problema"
                                                         style="max-height:300px; max-width:100%; border-radius:6px; border:1px solid #dee2e6; cursor:zoom-in;">
                                                </a>
                                            @else
                                                <p class="text-muted"><i class="fas fa-exclamation-circle mr-1"></i>Imagen no disponible.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if($ticket->comentarios->count())
                            <hr>
                            <h5><i class="fas fa-comments mr-1"></i> Comentarios ({{ $ticket->comentarios->count() }})</h5>
                            <div class="row">
                                @foreach($ticket->comentarios as $comentario)
                                <div class="col-lg-12">
                                    <div class="card card-outline card-info mb-2">
                                        <div class="card-body py-2">
                                            <strong>{{ $comentario->usuario->name ?? 'N/A' }}</strong>
                                            @if($comentario->usuario?->tipoUsuario)
                                                <small class="text-muted">"{{ $comentario->usuario->tipoUsuario->nombre_tipo }}"</small>
                                            @endif
                                            <span class="text-muted float-right">{{ $comentario->fecha }}</span>
                                            <p class="mb-0 mt-1">{{ $comentario->mensaje }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            {{-- ====== HISTORIAL FICTICIO DE ATENCIÓN ====== --}}
                            <hr>
                            <h5 class="mb-3">
                                <i class="fas fa-history mr-1"></i> Historial de Atención
                                @php $ultimo = end($historial); @endphp
                                @if(isset($ultimo['resuelto']))
                                    @if($ultimo['resuelto'])
                                        <span class="badge badge-success ml-2"><i class="fas fa-check mr-1"></i>Resuelto</span>
                                    @else
                                        <span class="badge badge-danger ml-2"><i class="fas fa-times mr-1"></i>Sin resolver</span>
                                    @endif
                                @endif
                            </h5>

                            <div class="timeline">
                                @foreach($historial as $entrada)
                                @php
                                    $esCliente = $entrada['rol'] === 'Cliente';
                                @endphp
                                <div>
                                    {{-- Punto de tiempo --}}
                                    <i class="fas fa-clock bg-gray" style="font-size:0.7rem;"></i>
                                    <div class="timeline-item">
                                        <span class="time text-muted">
                                            <i class="fas fa-clock mr-1"></i>{{ $entrada['fecha'] }}
                                        </span>
                                        <h3 class="timeline-header {{ $esCliente ? 'border-left border-' . $entrada['color'] : '' }}" style="padding-left: {{ $esCliente ? '8px' : '0' }}">
                                            <span class="badge badge-{{ $entrada['color'] }} mr-2">
                                                <i class="{{ $entrada['icono'] }}"></i>
                                            </span>
                                            <strong>{{ $entrada['autor'] }}</strong>
                                            <small class="text-muted ml-1">"{{ $entrada['rol'] }}"</small>
                                        </h3>
                                        <div class="timeline-body">
                                            {{ $entrada['msg'] }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div>
                                    <i class="fas fa-flag bg-gray" style="font-size:0.7rem;"></i>
                                </div>
                            </div>
                            {{-- ====== FIN HISTORIAL ====== --}}
                        </div>
                        <div class="card-footer">
                            <div class="row align-items-center">
                                <div class="col-lg-2 col-xs-4">
                                    <a href="{{ route('tickets.index') }}" class="btn btn-danger btn-block btn-flat">
                                        <i class="fas fa-arrow-left mr-1"></i> Atrás
                                    </a>
                                </div>
                                <div class="col-lg-3 col-xs-4">
                                    <a href="{{ route('tickets.exportPdf', $ticket->id) }}"
                                       class="btn btn-primary btn-block btn-flat"
                                       title="Descargar PDF con historial completo">
                                        <i class="fas fa-file-download mr-1"></i> Descargar PDF
                                    </a>
                                </div>
                                <div class="col-lg-3 col-xs-4">
                                    <a href="{{ route('tickets.viewPdf', $ticket->id) }}"
                                       target="_blank"
                                       class="btn btn-info btn-block btn-flat"
                                       title="Ver PDF en el navegador">
                                        <i class="fas fa-file-pdf mr-1"></i> Ver PDF
                                    </a>
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
