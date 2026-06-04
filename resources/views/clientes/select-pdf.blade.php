@extends('layouts.app')

@section('title','Seleccionar Cliente para Descargar PDF')

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
                <div class="col-md-10 offset-md-1">
                    <div class="card">
                        <div class="card-header" style="background-color: #17a2b8; color: white; font-size: 1.3rem; font-weight: 500; padding: 1rem;">
                            <i class="fas fa-file-pdf"></i> Seleccionar Cliente para Descargar PDF
                        </div>
                        <div class="card-body" style="padding: 2rem;">
                            <p style="color: #666; font-size: 1rem; margin-bottom: 1.5rem;">Elige una opción:</p>

                            <!-- Botón Descargar Todos -->
                            <div style="margin-bottom: 2rem;">
                                <a href="{{ route('clientes.exportPdf', 'all') }}" class="btn btn-success btn-block" style="padding: 1rem; font-size: 1.1rem; border-radius: 0.5rem;">
                                    <i class="fas fa-download"></i> Descargar PDF de Todos los Clientes
                                </a>
                            </div>

                            <hr style="margin: 2rem 0; border-color: #ddd;">

                            <p style="color: #666; font-size: 1rem; margin-bottom: 1.5rem;">O selecciona un cliente específico:</p>

                            <!-- Grid de Clientes 2 columnas -->
                            <div class="row">
                                @forelse($clientes as $cliente)
                                <div class="col-md-6 mb-3">
                                    <div class="card" style="border: 2px solid #e3f2fd; border-radius: 0.5rem; background-color: #f8f9fa; transition: all 0.3s ease;">
                                        <div class="card-body" style="padding: 1.25rem; display: flex; justify-content: space-between; align-items: center;">
                                            <div style="flex-grow: 1;">
                                                <h5 style="color: #1976d2; font-weight: 600; margin-bottom: 0.5rem;">
                                                    {{ $cliente->nombre }}
                                                </h5>
                                                <p style="color: #999; font-size: 0.9rem; margin-bottom: 0.25rem;">
                                                    ID: {{ $cliente->id }}
                                                </p>
                                                <p style="color: #999; font-size: 0.85rem; margin: 0;">
                                                    {{ $cliente->email ?? 'Sin email' }}
                                                </p>
                                            </div>
                                            <div style="display: flex; gap: 0.5rem; margin-left: 1rem;">
                                                <a href="{{ route('clientes.viewPdf', $cliente->id) }}" 
                                                   target="_blank"
                                                   class="btn btn-primary btn-sm"
                                                   title="Ver PDF"
                                                   style="padding: 0.5rem 0.75rem; background-color: #1976d2; border: none;">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('clientes.exportPdf', $cliente->id) }}" 
                                                   class="btn btn-primary btn-sm"
                                                   title="Descargar PDF"
                                                   style="padding: 0.5rem 0.75rem; background-color: #1976d2; border: none;">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="alert alert-info" role="alert">
                                        <i class="fas fa-exclamation-triangle"></i> No hay clientes registrados.
                                    </div>
                                </div>
                                @endforelse
                            </div>

                            <!-- Paginación -->
                            @if($clientes->hasPages())
                            <nav aria-label="Page navigation" style="margin-top: 2.5rem; display: flex; justify-content: center;">
                                <ul class="pagination" style="margin: 0; gap: 0.5rem; display: flex; align-items: center; list-style: none; padding: 0;">
                                    {{-- Previous Page Link --}}
                                    @if ($clientes->onFirstPage())
                                        <li>
                                            <span style="padding: 0.6rem 0.85rem; border: 1px solid #ddd; border-radius: 0.35rem; color: #ccc; cursor: not-allowed; background-color: #f8f9fa; display: inline-block; font-size: 0.9rem; transition: all 0.3s;">
                                                <i class="fas fa-chevron-left"></i> Anterior
                                            </span>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $clientes->previousPageUrl() }}" style="padding: 0.6rem 0.85rem; border: 1px solid #1976d2; border-radius: 0.35rem; color: #1976d2; background-color: white; text-decoration: none; display: inline-block; font-size: 0.9rem; transition: all 0.3s ease; font-weight: 500;"
                                               onmouseover="this.style.backgroundColor='#1976d2'; this.style.color='white'; this.style.boxShadow='0 2px 6px rgba(25, 118, 210, 0.3)';"
                                               onmouseout="this.style.backgroundColor='white'; this.style.color='#1976d2'; this.style.boxShadow='none';">
                                                <i class="fas fa-chevron-left"></i> Anterior
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @foreach ($clientes->getUrlRange(1, $clientes->lastPage()) as $page => $url)
                                        @if ($page == $clientes->currentPage())
                                            <li>
                                                <span style="padding: 0.6rem 0.85rem; border: 1px solid #1976d2; border-radius: 0.35rem; background-color: #1976d2; color: white; font-weight: 600; min-width: 2.5rem; text-align: center; display: inline-block; font-size: 0.9rem;">
                                                    {{ $page }}
                                                </span>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ $url }}" style="padding: 0.6rem 0.85rem; border: 1px solid #ddd; border-radius: 0.35rem; color: #333; background-color: white; text-decoration: none; display: inline-block; font-size: 0.9rem; transition: all 0.3s ease; min-width: 2.5rem; text-align: center; font-weight: 500;"
                                                   onmouseover="this.style.backgroundColor='#e3f2fd'; this.style.borderColor='#1976d2'; this.style.color='#1976d2';"
                                                   onmouseout="this.style.backgroundColor='white'; this.style.borderColor='#ddd'; this.style.color='#333';">
                                                    {{ $page }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($clientes->hasMorePages())
                                        <li>
                                            <a href="{{ $clientes->nextPageUrl() }}" style="padding: 0.6rem 0.85rem; border: 1px solid #1976d2; border-radius: 0.35rem; color: #1976d2; background-color: white; text-decoration: none; display: inline-block; font-size: 0.9rem; transition: all 0.3s ease; font-weight: 500;"
                                               onmouseover="this.style.backgroundColor='#1976d2'; this.style.color='white'; this.style.boxShadow='0 2px 6px rgba(25, 118, 210, 0.3)';"
                                               onmouseout="this.style.backgroundColor='white'; this.style.color='#1976d2'; this.style.boxShadow='none';">
                                                Siguiente <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <span style="padding: 0.6rem 0.85rem; border: 1px solid #ddd; border-radius: 0.35rem; color: #ccc; cursor: not-allowed; background-color: #f8f9fa; display: inline-block; font-size: 0.9rem; transition: all 0.3s;">
                                                Siguiente <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                            @endif

                            <div style="margin-top: 2rem;">
                                <a href="{{ route('clientes.index') }}" class="btn btn-secondary" style="width: 100%; padding: 0.75rem;">
                                    <i class="fas fa-arrow-left"></i> Volver al Listado
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 </div>

<style>
    .card {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        border-color: #1976d2 !important;
    }
    
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
    }
    
    .btn-success:hover {
        background-color: #218838;
        border-color: #218838;
    }
</style>

@endsection
