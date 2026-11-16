<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de acuerdos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            max-width: 1000px;
        }

        .contenedor {
            border: 1px solid #ccc;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .acuerdo {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .campo {
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 9px 15px;
            margin: 10px 5px 10px 0;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            background: #245b91;
        }

        .btn-secundario {
            background: #555;
        }

        .mensaje {
            background: #e1f4e5;
            padding: 12px;
            margin-bottom: 15px;
            color: #205b2c;
        }

        .vacio {
            padding: 15px;
            background: #f4f4f4;
        }
    </style>
</head>
<body>

    <h1>Historial de acuerdos y decisiones</h1>

    <h3>Proyecto: {{ $proyecto->nombre }}</h3>
    <p>Código: {{ $proyecto->codigo }}</p>

    @if(session('success'))
        <div class="mensaje">
            {{ session('success') }}
        </div>
    @endif

    <div class="contenedor">

        <a href="{{ route('proyectos.aprobaciones.create', $proyecto) }}"
           class="btn">
            Registrar nuevo acuerdo
        </a>

        <a href="{{ route('proyectos.show', $proyecto) }}"
           class="btn btn-secundario">
            Volver al proyecto
        </a>

        <h2>Acuerdos registrados</h2>

        @forelse($aprobaciones as $aprobacion)

            <div class="acuerdo">

                <div class="campo">
                    <strong>Decisión:</strong>
                    {{ $aprobacion->tipo_decision }}
                </div>

                <div class="campo">
                    <strong>Fecha del acuerdo:</strong>
                    {{ $aprobacion->fecha_acuerdo->format('d/m/Y') }}
                </div>

                <div class="campo">
                    <strong>Responsable:</strong>
                    {{ $aprobacion->responsable->name }}
                </div>

                <div class="campo">
                    <strong>Justificación:</strong>
                    {{ $aprobacion->justificacion }}
                </div>

                <div class="campo">
                    <strong>Registrado por:</strong>
                    {{ $aprobacion->registradoPor->name }}
                </div>

            </div>

        @empty

            <div class="vacio">
                Todavía no existen acuerdos registrados para este proyecto.
            </div>

        @endforelse

    </div>

</body>
</html>
