<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detalle Cliente - {{ $cliente->nombre }}</title>
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
        .info-row {
            display: flex;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .info-label {
            width: 30%;
            font-weight: bold;
            color: #555;
        }
        .info-value {
            width: 70%;
            color: #333;
            word-break: break-word;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
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
            font-size: 12px;
        }
        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 11px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Detalle del Cliente</h1>
            <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="section">
            <div class="section-title">Información del Cliente</div>
            <div class="info-row">
                <div class="info-label">ID:</div>
                <div class="info-value">#{{ $cliente->id }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nombre:</div>
                <div class="info-value">{{ $cliente->nombre }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $cliente->email ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Teléfono:</div>
                <div class="info-value">{{ $cliente->telefono ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Dirección:</div>
                <div class="info-value">{{ $cliente->direccion ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Estado:</div>
                <div class="info-value">
                    <span class="badge {{ $cliente->estado ? 'badge-success' : 'badge-danger' }}">
                        {{ $cliente->estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Registrado por:</div>
                <div class="info-value">{{ $cliente->registradopor ?? 'Sistema' }}</div>
            </div>
        </div>

        @if($cliente->tickets->count())
        <div class="section">
            <div class="section-title">Tickets Asociados ({{ $cliente->tickets->count() }})</div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Usuario Asignado</th>
                        <th>Fecha Creación</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cliente->tickets as $ticket)
                    <tr>
                        <td>#{{ $ticket->id }}</td>
                        <td>{{ $ticket->titulo }}</td>
                        <td>{{ $ticket->usuarioAsignado->name ?? 'Sin asignar' }}</td>
                        <td>{{ $ticket->fecha_creacion?->format('d/m/Y H:i') ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $ticket->estado ? 'badge-success' : 'badge-danger' }}">
                                {{ $ticket->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="section">
            <div class="section-title">Tickets Asociados</div>
            <p style="color: #999; font-style: italic;">No hay tickets registrados para este cliente</p>
        </div>
        @endif

        <div class="footer">
            <p>Este documento es un reporte generado automáticamente del sistema.</p>
            <p>Reporte generado: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
