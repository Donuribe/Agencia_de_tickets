@extends('layouts.app')

@section('title','Ver Comentario')

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
                            @yield('title') #{{ $comentario->id }}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Mensaje</label>
                                        <p>{{ $comentario->mensaje }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Ticket</label>
                                        <p>
                                            <a href="{{ route('tickets.show', $comentario->ticket_id) }}">
                                                #{{ $comentario->ticket_id }} - {{ $comentario->ticket->titulo ?? 'N/A' }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Usuario</label>
                                        <p>
                                            {{ $comentario->usuario->name ?? 'N/A' }}
                                            @if($comentario->usuario?->tipoUsuario)
                                                <small class="text-muted">"{{ $comentario->usuario->tipoUsuario->nombre_tipo }}"</small>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Fecha</label>
                                        <p>{{ $comentario->fecha }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Estado</label>
                                        <p>
                                            <span class="badge {{ $comentario->estado ? 'badge-success' : 'badge-danger' }}">
                                                {{ $comentario->estado ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row align-items-center">
                                <div class="col-lg-2 col-xs-4">
                                    <a href="{{ route('comentarios.index') }}" class="btn btn-danger btn-block btn-flat">
                                        <i class="fas fa-arrow-left mr-1"></i> Atrás
                                    </a>
                                </div>
                                <div class="col-lg-2 col-xs-4">
                                    <a href="{{ route('comentarios.edit', $comentario->id) }}" class="btn btn-warning btn-block btn-flat">
                                        <i class="fas fa-pencil-alt mr-1"></i> Editar
                                    </a>
                                </div>
                                <div class="col-lg-3 col-xs-4">
                                    <a href="{{ route('comentarios.exportPdf', $comentario->id) }}"
                                       class="btn btn-primary btn-block btn-flat"
                                       title="Descargar PDF">
                                        <i class="fas fa-file-download mr-1"></i> Descargar PDF
                                    </a>
                                </div>
                                <div class="col-lg-3 col-xs-4">
                                    <a href="{{ route('comentarios.viewPdf', $comentario->id) }}"
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
