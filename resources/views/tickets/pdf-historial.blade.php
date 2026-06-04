<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Historial Ticket #{{ $ticket->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.6; color: #333; }
        .container { width: 100%; padding: 20px; }

        /* Encabezado */
        .header { text-align: center; margin-bottom: 25px; border-bottom: 3px solid #007bff; padding-bottom: 15px; }
        .header h1 { color: #007bff; font-size: 22px; margin-bottom: 4px; }
        .header p { color: #666; font-size: 11px; }

        /* Secciones */
        .section { margin-bottom: 20px; }
        .section-title {
            background-color: #007bff; color: #fff;
            padding: 7px 12px; font-size: 13px; font-weight: bold;
            margin-bottom: 10px; border-radius: 3px;
        }

        /* Filas de info */
        .info-row { display: flex; padding: 6px 0; border-bottom: 1px solid #eee; }
        .info-label { width: 32%; font-weight: bold; color: #555; }
        .info-value { width: 68%; word-break: break-word; }

        /* Badges */
        .badge { display: inline-block; padding: 3px 8px; border-radius: 3px; font-size: 11px; font-weight: bold; }
        .badge-success { background-color: #28a745; color: #fff; }
        .badge-danger  { background-color: #dc3545; color: #fff; }
        .badge-info    { background-color: #17a2b8; color: #fff; }
        .badge-warning { background-color: #ffc107; color: #333; }
        .badge-secondary { background-color: #6c757d; color: #fff; }

        /* Comentarios */
        .comentario { background-color: #f0f7ff; border-left: 3px solid #007bff; padding: 10px; margin-bottom: 10px; border-radius: 3px; }
        .comentario-header { font-weight: bold; color: #007bff; font-size: 11px; margin-bottom: 4px; }
        .comentario-rol { color: #888; font-style: italic; }
        .comentario-fecha { color: #999; font-size: 10px; float: right; }
        .comentario-texto { color: #333; margin-top: 5px; }

        /* Historial de atención */
        .historial-entry { margin-bottom: 12px; padding: 10px 12px; border-radius: 4px; border-left: 4px solid #ccc; }
        .historial-entry.recepcion  { border-color: #17a2b8; background: #f0fbff; }
        .historial-entry.diagnostico { border-color: #ffc107; background: #fffdf0; }
        .historial-entry.traslado   { border-color: #6c757d; background: #f8f8f8; }
        .historial-entry.solucion   { border-color: #28a745; background: #f0fff4; }
        .historial-entry.cierre_ok  { border-color: #28a745; background: #e8f8ee; }
        .historial-entry.cierre_nok { border-color: #dc3545; background: #fff0f0; }

        .historial-autor { font-weight: bold; font-size: 12px; }
        .historial-rol   { color: #777; font-style: italic; font-size: 11px; margin-left: 4px; }
        .historial-fecha { color: #999; font-size: 10px; float: right; }
        .historial-msg   { margin-top: 5px; color: #444; font-size: 11px; }

        /* Resultado final */
        .resultado-box { text-align: center; padding: 12px; border-radius: 5px; margin-top: 10px; font-weight: bold; font-size: 14px; }
        .resultado-ok  { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .resultado-nok { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* Imagen captura */
        .captura-img { max-width: 100%; max-height: 300px; border-radius: 4px; border: 1px solid #dee2e6; margin-top: 5px; }

        /* Footer */
        .footer { margin-top: 25px; padding-top: 12px; border-top: 1px solid #ddd; font-size: 10px; color: #aaa; text-align: center; }

        .clearfix::after { content: ""; display: table; clear: both; }
    </style>
</head>
<body>
<div class="container">

    {{-- ENCABEZADO --}}
    <div class="header">
        <h1>Historial del Ticket #{{ $ticket->id }}</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    {{-- INFORMACIÓN GENERAL --}}
    <div class="section">
        <div class="section-title">Información General</div>
        <div class="info-row">
            <div class="info-label">Ticket:</div>
            <div class="info-value">#{{ $ticket->id }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Título:</div>
            <div class="info-value">{{ $ticket->titulo }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Estado:</div>
            <div class="info-value">
                <span class="badge {{ $ticket->estado ? 'badge-success' : 'badge-danger' }}">
                    {{ $ticket->estado ? 'Activo' : 'Inactivo' }}
                </span>
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Cliente:</div>
            <div class="info-value">{{ $ticket->cliente->nombre ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Usuario Asignado:</div>
            <div class="info-value">
                {{ $ticket->usuarioAsignado->name ?? 'Sin asignar' }}
                @if($ticket->usuarioAsignado?->tipoUsuario)
                    "{{ $ticket->usuarioAsignado->tipoUsuario->nombre_tipo }}"
                @endif
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Registrado Por:</div>
            <div class="info-value">{{ $ticket->registrado_por ?? 'Sistema' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Fecha de Creación:</div>
            <div class="info-value">{{ $ticket->fecha_creacion ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Fecha de Cierre:</div>
            <div class="info-value">{{ $ticket->fecha_cierre ?? 'Sin cerrar' }}</div>
        </div>
    </div>

    {{-- DESCRIPCIÓN --}}
    <div class="section">
        <div class="section-title">Descripción del Problema</div>
        <div style="padding: 10px; background: #f8f9fa; border-radius: 3px;">
            {{ $ticket->descripcion ?? 'Sin descripción' }}
        </div>
    </div>

    {{-- CAPTURA DEL PROBLEMA --}}
    @if($ticket->imagen)
    @php $imgPath = storage_path('app/public/uploads/tickets/' . $ticket->imagen); @endphp
    @if(file_exists($imgPath))
    <div class="section">
        <div class="section-title">Captura del Problema</div>
        <div style="text-align:center;">
            <img src="{{ $imgPath }}" class="captura-img" alt="Captura del problema">
        </div>
    </div>
    @endif
    @endif

    {{-- COMENTARIOS REALES --}}
    @if($ticket->comentarios->count())
    <div class="section">
        <div class="section-title">Comentarios ({{ $ticket->comentarios->count() }})</div>
        @foreach($ticket->comentarios as $comentario)
        <div class="comentario">
            <div class="comentario-header clearfix">
                <span>{{ $comentario->usuario->name ?? 'N/A' }}</span>
                @if($comentario->usuario?->tipoUsuario)
                    <span class="comentario-rol">"{{ $comentario->usuario->tipoUsuario->nombre_tipo }}"</span>
                @endif
                <span class="comentario-fecha">{{ $comentario->fecha }}</span>
            </div>
            <div class="comentario-texto">{{ $comentario->mensaje }}</div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- HISTORIAL DE ATENCIÓN FICTICIO --}}
    <div class="section">
        <div class="section-title">Historial de Atención al Cliente</div>

        @foreach($historial as $entrada)
        @if($entrada['tipo'] !== 'cierre_ok' && $entrada['tipo'] !== 'cierre_nok')
        <div class="historial-entry {{ $entrada['tipo'] }} clearfix">
            <div class="clearfix">
                <span class="historial-autor">{{ $entrada['autor'] }}</span>
                <span class="historial-rol">"{{ $entrada['rol'] }}"</span>
                <span class="historial-fecha">{{ $entrada['fecha'] }}</span>
            </div>
            <div class="historial-msg">{{ $entrada['msg'] }}</div>
        </div>
        @endif
        @endforeach

        {{-- Respuesta final del cliente --}}
        @php $cierreEntrada = collect($historial)->last(); @endphp
        @if(isset($cierreEntrada['resuelto']))
        <div class="historial-entry {{ $cierreEntrada['tipo'] }} clearfix" style="margin-top: 15px;">
            <div class="clearfix">
                <span class="historial-autor">{{ $cierreEntrada['autor'] }}</span>
                <span class="historial-rol">"{{ $cierreEntrada['rol'] }}"</span>
                <span class="historial-fecha">{{ $cierreEntrada['fecha'] }}</span>
            </div>
            <div class="historial-msg">{{ $cierreEntrada['msg'] }}</div>
        </div>

        <div class="resultado-box {{ $cierreEntrada['resuelto'] ? 'resultado-ok' : 'resultado-nok' }}">
            @if($cierreEntrada['resuelto'])
                ✔ PROBLEMA RESUELTO — El cliente confirmó que el inconveniente fue solucionado.
            @else
                ✘ PROBLEMA SIN RESOLVER — El cliente reporta que el inconveniente persiste.
            @endif
        </div>
        @endif
    </div>

    <div class="footer">
        <p>Documento generado automáticamente por el Sistema de Tickets.</p>
        <p>{{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

</div>
</body>
</html>
