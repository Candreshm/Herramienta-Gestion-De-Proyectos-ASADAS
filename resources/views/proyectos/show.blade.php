<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Iniciativa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            max-width: 800px;
        }

        .detalle {
            border: 1px solid #ccc;
            padding: 20px;
            margin-top: 20px;
        }

        .campo {
            margin-bottom: 18px;
        }

        .campo strong {
            display: block;
            margin-bottom: 5px;
        }

        .valor {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 3px;
        }

        .estado {
            color: #006600;
            font-weight: bold;
        }

        .btn {
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 3px;
            display: inline-block;
            margin-top: 15px;
        }

        .btn-primary {
            background-color: #0066cc;
            color: white;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>

<body>

    <h1>Detalle de la Iniciativa</h1>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="detalle">

        <div class="campo">
            <strong>Código:</strong>

            <div class="valor">
                {{ $proyecto->codigo }}
            </div>
        </div>

        <div class="campo">
            <strong>Nombre de la iniciativa:</strong>

            <div class="valor">
                {{ $proyecto->nombre }}
            </div>
        </div>

        <div class="campo">
            <strong>Descripción:</strong>

            <div class="valor">
                {{ $proyecto->descripcion }}
            </div>
        </div>

        <div class="campo">
            <strong>Objetivo:</strong>

            <div class="valor">
                {{ $proyecto->objetivo }}
            </div>
        </div>

        <div class="campo">
            <strong>Estado:</strong>

            <div class="valor estado">
                {{ $proyecto->estado->nombre }}
            </div>
        </div>

        <div class="campo">
            <strong>Registrado por:</strong>

            <div class="valor">
                {{ $proyecto->creador->name }}
            </div>
        </div>

        <div class="campo">
            <strong>Fecha de registro:</strong>

            <div class="valor">
                {{ $proyecto->created_at?->format('d/m/Y H:i') }}
            </div>
        </div>

    </div>

    <hr>

<h2>Información de HU-05</h2>

        <p>
            <strong>Justificación:</strong><br>
            {{ $proyecto->justificacion ?: 'No registrada' }}
        </p>

        <p>
            <strong>Costo estimado:</strong><br>
            @if ($proyecto->costo_estimado !== null)
                ₡{{ number_format($proyecto->costo_estimado, 2) }}
            @else
                No registrado
            @endif
        </p>

        <p>
            <strong>Impacto esperado:</strong><br>
            {{ $proyecto->impacto_esperado ?: 'No registrado' }}
        </p>

        <p>
            <strong>Nivel de riesgo:</strong><br>
            {{ $proyecto->nivel_riesgo ?: 'No registrado' }}
        </p>

        <p>
            <strong>Criticidad:</strong><br>
            {{ $proyecto->criticidad ?: 'No registrada' }}
        </p>

         <p>
            <strong>Prioridad:</strong><br>
            {{ $proyecto->prioridad ?: 'No registrada' }}
        </p>

    <p>
        <a
            href="{{ route('proyectos.index') }}"
            class="btn btn-primary"
        >
            &larr; Volver al listado
        </a>
        <a
            href="{{ route('proyectos.hu05.edit', $proyecto) }}"
            style="
                display:inline-block;
                padding:10px 15px;
                background:#28a745;
                color:white;
                text-decoration:none;
                border-radius:5px;
                margin-right:10px;
    "
        >
            Completar información HU-05
</a>
    </p>

    <hr>

<h2>Evidencia inicial</h2>

@if ($proyecto->evidencias->count() > 0)

    <ul>
        @foreach ($proyecto->evidencias as $evidencia)
            <li>
                <a
                    href="{{ asset('storage/' . $evidencia->ruta) }}"
                    target="_blank"
                >
                    {{ $evidencia->nombre_original }}
                </a>

                <span style="color:#666;">
                    ({{ number_format(($evidencia->tamano ?? 0) / 1024, 2) }} KB)
                </span>
            </li>
        @endforeach
    </ul>

@else

    <p>No se ha registrado evidencia inicial.</p>

@endif

</body>
</html>
