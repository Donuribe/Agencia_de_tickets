<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listado Completo de Clientes</title>
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
        .cliente-block {
            page-break-inside: avoid;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            background-color: #fff;
        }
        .cliente-header {
            background-color: #007bff;
            color: white;
            padding: 12px 15px;
            font-size: 13px;
            font-weight: bold;
        }
        .cliente-content {
            padding: 12px 15px;
        }
        .info-row {
            display: flex;
            margin-bottom: 6px;
            padding: 4px 0;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }
        table th {
            background-color: #e9ecef;
            color: #333;
            padding: 6px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table td {
            padding: 5px 6px;
            border-bottom: 1px solid #eee;
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
        .info-label-small {
            font-weight: bold;
            color: #666;
        }
        .info-value-small {
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
        .sin-clientes {
            text-align: center;
            padding: 30px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📇 Listado Completo de Clientes</h1>
            <p>Total de clientes: {{ count($clientes) }}</p>
            <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        @if(count($clientes) > 0)
            <div class="resumen">
                <h3>📊 Resumen</h3>
                <div class="info-item">
                    <span class="info-label-small">Total de Clientes:</span>
                    <span class="info-value-small">{{ count($clientes) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label-small">Activos:</span>
                    <span class="info-value-small">{{ $clientes->where('estado', true)->count() }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label-small">Inactivos:</span>
                    <span class="info-value-small">{{ $clientes->where('estado', false)->count() }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label-small">Total Tickets:</span>
                    <span class="info-value-small">{{ $clientes->sum(fn($c) => $c->tickets->count()) }}</span>
                </div>
            </div>

            @foreach($clientes as $cliente)
            <div class="cliente-block">
                <div class="cliente-header">
                    {{ $cliente->nombre }} (ID: #{{ $cliente->id }})
                </div>
                
                <div class="cliente-content">
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

                    @if($cliente->tickets->count() > 0)
                    <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">
                        <strong style="font-size: 11px; color: #007bff;">Tickets ({{ $cliente->tickets->count() }})</strong>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cliente->tickets as $ticket)
                                <tr>
                                    <td>#{{ $ticket->id }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($ticket->titulo, 30) }}</td>
                                    <td>{{ $ticket->usuarioAsignado->name ?? 'Sin asignar' }}</td>
                                    <td>{{ $ticket->fecha_creacion?->format('d/m/Y') ?? 'N/A' }}</td>
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
                    @endif
                </div>
            </div>
            @endforeach
        @else
            <div class="sin-clientes">
                No hay clientes registrados
            </div>
        @endif

        <div class="footer">
            <p>Este documento es un reporte generado automáticamente del sistema.</p>
            <p>Reporte generado: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
