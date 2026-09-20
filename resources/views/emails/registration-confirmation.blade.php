<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Registro</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 20px;
            color: #334155;
        }
        .container {
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #135860;
            color: #ffffff;
            padding: 30px 25px;
            text-align: left;
        }
        .badge {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 10px;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 25px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #135860;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
            margin-top: 30px;
            margin-bottom: 16px;
        }
        .card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
        }
        .card-camper {
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
        }
        .medical-subcard {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            margin-top: 12px;
        }
        .info-row {
            margin-bottom: 8px;
            font-size: 14px;
            color: #334155;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .info-row strong {
            color: #475569;
        }
        .btn-container {
            text-align: center;
            margin: 35px 0 20px 0;
            padding: 20px;
            background-color: rgba(19, 88, 96, 0.03);
            border-radius: 12px;
            border: 1px border #e2e8f0;
        }
        .btn-giant {
            display: inline-block;
            width: 80%;
            background-color: #135860;
            color: #ffffff !important;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(19, 88, 96, 0.2);
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header principal estilizado según el banner activo del form -->
    <div class="header">
        <span class="badge">Registro Confirmado</span>
        <h1>¡Registro Completado con Éxito!</h1>
        <p style="color: #e2e8f0; font-size: 14px; margin-top: 6px; margin-bottom: 0;">
            Evento: <strong>{{ $session->campEvent->name ?? 'Campamento' }}</strong>
        </p>
    </div>

    <div class="content">
        <p style="font-size: 15px; line-height: 1.5; color: #334155; margin-top: 0;">
            Hola, tu registro se completó exitosamente. A continuación, te mostramos un resumen con la información guardada:
        </p>

        <!-- Resumen de Tutores / Guardias -->
        <div class="section-title">1. Parent / Guardian Information</div>
        @foreach($session->guardians as $guardian)
            <div class="card">
                <div class="info-row"><strong>Nombre:</strong> {{ $guardian->first_name }} {{ $guardian->last_name }}</div>
                <div class="info-row"><strong>Teléfono:</strong> {{ $guardian->phone }}</div>
                <div class="info-row"><strong>Correo electrónico:</strong> {{ $guardian->email ?? 'N/A' }}</div>
                <div class="info-row"><strong>Parentesco:</strong> {{ ucfirst($guardian->pivot->relationship_type ?? 'N/A') }}</div>
            </div>
        @endforeach

        <!-- Resumen de Acampantes -->
        <div class="section-title">2. Camper Information</div>
        @foreach($session->camperRegistrations as $registration)
            @php
                $camper = $registration->camper;
                $medical = $camper->medical;
            @endphp
            @if($camper)
                <div class="card-camper">
                    <div class="info-row"><strong>Nombre del Acampante:</strong> {{ $camper->first_name }} {{ $camper->last_name }}</div>
                    <div class="info-row"><strong>Fecha de Nacimiento:</strong> {{ $camper->date_of_birth }}</div>
                    <div class="info-row"><strong>Género:</strong> {{ ucfirst($camper->gender->value ?? $camper->gender) }}</div>
                    
                    @if($medical)
                        <div class="medical-subcard">
                            <div style="font-size: 12px; font-weight: bold; color: #0f172a; margin-bottom: 8px; border-bottom: 1px solid #f1f5f9; padding-bottom: 4px;">
                                Perfil Médico & Consideraciones
                            </div>
                            <div class="info-row"><strong>Alergias:</strong> {{ $medical->allergies ?: 'Ninguna' }}</div>
                            <div class="info-row"><strong>Medicamentos:</strong> {{ $medical->medications ?: 'Ninguno' }}</div>
                            <div class="info-row"><strong>Restricciones Alimentarias:</strong> {{ $medical->dietary_restrictions ?: 'Ninguna' }}</div>
                        </div>
                    @endif
                </div>
            @endif
        @endforeach

        <!-- Botón para modificar -->
        <div class="btn-container">
            <p style="font-size: 14px; color: #475569; margin-top: 0; margin-bottom: 16px;">
                Si necesitas realizar algún cambio o actualizar la información, puedes hacerlo directamente presionando el siguiente botón:
            </p>
            <a href="{{ $editUrl }}" class="btn-giant">
                MODIFICAR MI REGISTRO
            </a>
            <p style="font-size: 12px; color: #e11d48; margin-top: 12px; margin-bottom: 0;">
                * Este enlace es personal, seguro y vencerá en 15 días.
            </p>
        </div>

        <div class="footer">
            Si no realizaste esta solicitud, por favor ignora este correo.<br>
            © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
        </div>
    </div>
</div>

</body>
</html>