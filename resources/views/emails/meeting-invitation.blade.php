<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitación a Reunión</title>
    <style>
        /* Reset de estilos */
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

        .greeting {
            font-size: 24px;
            color: #1e40af;
            margin-bottom: 20px;
        }

        .meeting-details {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }

        .meeting-item {
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .meeting-item:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: bold;
            color: #1e40af;
            width: 140px;
            display: inline-block;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #2563eb;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            text-align: center;
        }

        .button:hover {
            background-color: #1e40af;
        }

        .footer {
            margin-top: 30px;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .note {
            font-style: italic;
            color: #64748b;
            margin-top: 20px;
            font-size: 14px;
        }

        /* Responsive */
        @media screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }

            .content {
                padding: 20px 15px !important;
            }

            .label {
                display: block;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Invitación a Reunión</h1>
    </div>

    <div class="content">
        <h2 class="greeting">hola {{ $nombre }}!,</h2>

        <p>Por medio de la presente, se le invita cordialmente a participar en la siguiente reunión:</p>

        <div class="meeting-details">
            <div class="meeting-item">
                <span class="label">Lugar:</span>
                <span>{{ $lugar }}</span>
            </div>

            <div class="meeting-item">
                <span class="label">Fecha:</span>
                <span>{{$fecha}}</span>
            </div>

            <div class="meeting-item">
                <span class="label">Hora:</span>
                <span>{{ \Illuminate\Support\Carbon::parse($hora)->format('H:i') }}</span>
            </div>

            <div class="meeting-item">
                <span class="label">Presidente:</span>
                <span>{{ $presidente }}</span>
            </div>

            <div class="meeting-item">
                <span class="label">Secretario:</span>
                <span>{{ $secretario }}</span>
            </div>
        </div>

        <p class="note">* Se agradece puntual asistencia. En caso de no poder asistir, favor de notificar con anticipación.</p>
    </div>

    <div class="footer">
        <p>Este es un correo automático, por favor no responder.</p>
        <p>{{ config('app.name') }} - {{ date('Y') }}</p>
    </div>
</div>
</body>
</html>
