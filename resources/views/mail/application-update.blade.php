<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de Solicitud</title>
    <style>
        body, table, td, div, p {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
        }

        .header {
            background-color: #2563eb;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 30px 20px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0 0 8px 8px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 10px;
        }

        .section-content p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Actualización de Solicitud</h1>
        </div>
        <div class="content">
            <div class="section">
                <div class="section-title">Detalles de la Solicitud</div>
                <div class="section-content">
                    <p><strong>Dependencia:</strong> {{ $application['DEPENDENCIA'] }}</p>
                    <p><strong>Asunto:</strong> {{ $application['ASUNTO'] }}</p>
                    <p><strong>Decisión:</strong> {{ $application['DESICION'] }}</p>
                    <p><strong>Fecha de Solicitud:</strong> {{ $application['FECHA_DE_SOLICITUD'] }}</p>
                </div>
            </div>
            <div class="section">
                <div class="section-title">Detalles de la Sesión</div>
                <div class="section-content">
                    <p><strong>Lugar:</strong> {{ $application['sesion']['LUGAR'] }}</p>
                    <p><strong>Fecha:</strong> {{ $application['sesion']['FECHA'] }}</p>
                    <p><strong>Hora de Inicio:</strong> {{ $application['sesion']['HORARIO_INICIO'] }}</p>
                    <p><strong>Hora de Finalización:</strong> {{ $application['sesion']['HORARIO_FINAL'] }}</p>
                    <p><strong>Presidente:</strong> {{ $application['sesion']['PRESIDENTE'] }}</p>
                    <p><strong>Secretario:</strong> {{ $application['sesion']['SECRETARIO'] }}</p>
                </div>
            </div>
            <div class="section">
                <div class="section-title">Detalles del Solicitante</div>
                <div class="section-content">
                    <p><strong>Nombre:</strong> {{ $application['solicitante']['NOMBRE'] }}</p>
                    <p><strong>Tipo:</strong> {{ $application['solicitante']['TIPO_DE_SOLICITANTE'] }}</p>
                    <p><strong>Email:</strong> {{ $application['solicitante']['EMAIL'] }}</p>
                    <p><strong>Celular:</strong> {{ $application['solicitante']['CELULAR'] }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
