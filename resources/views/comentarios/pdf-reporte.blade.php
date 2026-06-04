<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Comentarios</title>
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
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
        }
        .comentario-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 12px;
            page-break-inside: avoid;
        }
        .comentario-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #dee2e6;
        }
        .comentario-usuario {
            font-weight: bold;
            color: #007bff;
            font-size: 12px;
        }
        .comentario-fecha {
            color: #999;
            font-size: 10px;
        }
        .comentario-ticket {
            color: #666;
            font-size: 11px;
            margin-bottom: 6px;
        }
        .comentario-estado {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 6px;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        .comentario-mensaje {
            color: #333;
            font-size: 11px;
            line-height: 1.5;
            background-color: white;
            padding: 8px;
            border-radius: 3px;
            margin-top: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }
        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .resumen {
            background-color: #f8f9fa;
            border: 1px solid #007bff;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 11px;
        }
        .resumen h3 {
            color: #007bff;
            font-size: 13px;
            margin-bottom: 10px;
        }
        .info-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
        }
        .info-value {
            color: #333;
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
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💬 Reporte de Comentarios</h1>
            <p>Total de comentarios: {{ count($comentarios) }}</p>
            <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        @if(count($comentarios) > 0)
            <div class="resumen">
                <h3>📊 Resumen</h3>
                <div class="info-item">
                    <span class="info-label">Total de Comentarios:</span>
                    <span class="info-value">{{ count($comentarios) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Activos:</span>
                    <span class="info-value">{{ $comentarios->where('estado', true)->count() }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Inactivos:</span>
                    <span class="info-value">{{ $comentarios->where('estado', false)->count() }}</span>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Listado Detallado de Comentarios</div>
                
                @foreach($comentarios as $comentario)
                <div class="comentario-card">
                    <div class="comentario-header">
                        <div>
                            <div class="comentario-usuario">{{ $comentario->usuario->name ?? 'N/A' }}</div>
                            <div class="comentario-ticket">
                                Ticket: <strong>#{{ $comentario->ticket->id }}</strong> - {{ $comentario->ticket->titulo ?? 'N/A' }}
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div class="comentario-fecha">{{ $comentario->fecha }}</div>
                            <span class="comentario-estado {{ $comentario->estado ? 'badge-success' : 'badge-danger' }}">
                                {{ $comentario->estado ? 'ACTIVO' : 'INACTIVO' }}
                            </span>
                        </div>
                    </div>
                    <div class="comentario-mensaje">
                        {{ $comentario->mensaje }}
                    </div>
                </div>
                @endforeach
            </div>

            <div class="section">
                <div class="section-title">Tabla Resumen</div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Ticket</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Mensaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comentarios as $comentario)
                        <tr>
                            <td>#{{ $comentario->id }}</td>
                            <td>{{ $comentario->usuario->name ?? 'N/A' }}</td>
                            <td>#{{ $comentario->ticket->id }}</td>
                            <td>{{ $comentario->fecha }}</td>
                            <td>
                                <span class="comentario-estado {{ $comentario->estado ? 'badge-success' : 'badge-danger' }}">
                                    {{ $comentario->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($comentario->mensaje, 50) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="sin-comentarios">
                No hay comentarios registrados
            </div>
        @endif

        <div class="footer">
            <p>Este documento es un reporte generado automáticamente del sistema.</p>
            <p>Reporte generado: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
