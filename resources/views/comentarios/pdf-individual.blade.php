<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Comentario #{{ $comentario->id }}</title>
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
        .detail-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #666;
            width: 30%;
        }
        .detail-value {
            color: #333;
            width: 70%;
            text-align: right;
        }
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 11px;
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
        .mensaje-section {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .mensaje-titulo {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .mensaje-contenido {
            color: #333;
            line-height: 1.8;
            font-size: 12px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 12px;
        }
        .info-box-title {
            font-weight: bold;
            color: #007bff;
            font-size: 11px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .info-box-value {
            color: #333;
            font-size: 12px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💬 Detalle de Comentario</h1>
            <p>Comentario #{{ $comentario->id }}</p>
            <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="section">
            <div class="section-title">Información General</div>
            
            <div class="info-grid">
                <div class="info-box">
                    <div class="info-box-title">ID del Comentario</div>
                    <div class="info-box-value">#{{ $comentario->id }}</div>
                </div>
                <div class="info-box">
                    <div class="info-box-title">Estado</div>
                    <div class="info-box-value">
                        <span class="badge {{ $comentario->estado ? 'badge-success' : 'badge-danger' }}">
                            {{ $comentario->estado ? 'ACTIVO' : 'INACTIVO' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-row">
                    <div class="detail-label">Usuario:</div>
                    <div class="detail-value">{{ $comentario->usuario->name ?? 'N/A' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email del Usuario:</div>
                    <div class="detail-value">{{ $comentario->usuario->email ?? 'N/A' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Ticket:</div>
                    <div class="detail-value">#{{ $comentario->ticket->id }} - {{ $comentario->ticket->titulo ?? 'N/A' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Fecha del Comentario:</div>
                    <div class="detail-value">{{ $comentario->fecha }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Registrado por:</div>
                    <div class="detail-value">{{ $comentario->registrado_por ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Contenido del Mensaje</div>
            <div class="mensaje-section">
                <div class="mensaje-contenido">
                    {{ $comentario->mensaje }}
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Este documento es un reporte generado automáticamente del sistema.</p>
            <p>Reporte generado: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
