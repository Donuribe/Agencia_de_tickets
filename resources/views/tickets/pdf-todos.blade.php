<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Historial Completo de Tickets</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #007bff;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #007bff;
            font-size: 28px;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 12px;
        }
        .ticket-block {
            page-break-inside: avoid;
            margin-bottom: 30px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        .ticket-header {
            background-color: #007bff;
            color: white;
            padding: 12px 15px;
            font-size: 14px;
            font-weight: bold;
        }
        .section {
            margin-bottom: 15px;
            padding: 15px;
        }
        .section-title {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .info-row {
            display: flex;
            margin-bottom: 6px;
            font-size: 11px;
        }
        .info-label {
            width: 25%;
            font-weight: bold;
            color: #555;
        }
        .info-value {
            width: 75%;
            color: #333;
            word-break: break-word;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        .comentario {
            background-color: #f8f9fa;
            border-left: 3px solid #007bff;
            padding: 8px;
            margin-bottom: 8px;
            border-radius: 3px;
            font-size: 10px;
        }
        .comentario-header {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 3px;
        }
        .comentario-fecha {
            color: #999;
            font-size: 9px;
            display: inline-block;
            float: right;
        }
        .comentario-texto {
            color: #333;
            margin-top: 4px;
            line-height: 1.4;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #999;
            text-align: center;
        }
        .sin-comentarios {
            color: #999;
            font-style: italic;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Historial Completo de Tickets</h1>
            <p>Total de tickets: {{ count($tickets) }}</p>
            <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        @foreach($tickets as $ticket)
        <div class="ticket-block">
            <div class="ticket-header">
                Ticket #{{ $ticket->id }} - {{ $ticket->titulo }}
            </div>
            
            <div class="section">
                <div class="section-title">Información General</div>
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
                    <div class="info-value">{{ $ticket->usuarioAsignado->name ?? 'Sin asignar' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Fecha Creación:</div>
                    <div class="info-value">{{ $ticket->fecha_creacion ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Fecha Cierre:</div>
                    <div class="info-value">{{ $ticket->fecha_cierre ?? 'Sin cerrar' }}</div>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Descripción</div>
                <div class="info-value" style="font-size: 10px; line-height: 1.4;">
                    {{ $ticket->descripcion ?? 'Sin descripción' }}
                </div>
            </div>

            @if($ticket->comentarios->count())
            <div class="section">
                <div class="section-title">Comentarios ({{ $ticket->comentarios->count() }})</div>
                @foreach($ticket->comentarios as $comentario)
                <div class="comentario">
                    <div class="comentario-header">
                        {{ $comentario->usuario->name ?? 'N/A' }}
                        <span class="comentario-fecha">{{ $comentario->fecha }}</span>
                    </div>
                    <div class="comentario-texto">
                        {{ $comentario->mensaje }}
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="section">
                <div class="sin-comentarios">No hay comentarios</div>
            </div>
            @endif
        </div>
        @endforeach

        <div class="footer">
            <p>Este documento es un reporte generado automáticamente del sistema de tickets.</p>
            <p>Reporte generado: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
