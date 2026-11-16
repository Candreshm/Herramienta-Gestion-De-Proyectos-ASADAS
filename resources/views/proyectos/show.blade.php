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
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 15px;
                 border: 1px solid #f5c6cb;
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

    @if(session('error'))
        <div class="alert-error">
            {{ session('error') }}
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
        
        @if (auth()->user()->role?->nombre === 'Administrador')

        <p>
            <a href="{{ route('proyectos.index') }}" class="btn btn-primary">
                &larr; Volver al listado
            </a>

        @if (!in_array($proyecto->estado->nombre, ['Aprobado', 'Finalizado'], true))
            <a href="{{ route('proyectos.edit', $proyecto) }}" class="btn btn-primary">
                Editar proyecto
            </a>
        @endif

            <a href="{{ route('proyectos.hu05.edit', $proyecto) }}"
               class="btn btn-primary">
                Completar información HU-05
            </a>

            <a href="{{ route('proyectos.evaluacion.create', $proyecto) }}"
               class="btn btn-primary">
                Registrar evaluación HU-08
            </a>

            <a href="{{ route('proyectos.evaluacion.index', $proyecto) }}"
               class="btn btn-primary">
                Ver historial de evaluaciones
            </a>
        </p>

        @endif

        @if (in_array(auth()->user()->role?->nombre, ['Administrador', 'Secretaría'], true))

    <hr>

    <h2>HU-14: Acuerdos y decisiones</h2>

        <p>
            <a href="{{ route('proyectos.aprobaciones.create', $proyecto) }}"
               class="btn btn-primary">
                Registrar acuerdo
            </a>

            <a href="{{ route('proyectos.aprobaciones.index', $proyecto) }}"
               class="btn btn-primary">
                Consultar historial de acuerdos
            </a>
        </p>

    <h3>Últimos acuerdos registrados</h3>

        @forelse($proyecto->aprobaciones->sortByDesc('fecha_acuerdo')->take(5) as $aprobacion)

            <div class="detalle">

                <div class="campo">
                    <strong>Decisión:</strong>
                    {{ $aprobacion->tipo_decision }}
            </div>

                <div class="campo">
                    <strong>Fecha:</strong>
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

        </div>

        @empty

        <p>No hay acuerdos registrados para este proyecto.</p>

        @endforelse

        
    @endif

    @if (
        auth()->user()->activo &&
        (int) auth()->id() === (int) $proyecto->creado_por_id
    )
        <hr>

        <h2>HU-17: Seguimiento del proyecto</h2>

        <p>
                Desde esta sección puede administrar los hitos, registrar los
                avances y dar seguimiento a las incidencias del proyecto.
        </p>

        <p>
            <a     href="{{ route('proyectos.hitos.index', $proyecto) }}"
                   class="btn btn-primary">
                    Gestionar hitos
                </a>

            <a     href="{{ route('proyectos.avances.index', $proyecto) }}"
                   class="btn btn-primary">
                   Consultar avances
                </a>

            <a     href="{{ route('proyectos.incidencias.index', $proyecto) }}"
                   class="btn btn-primary">
                    Gestionar incidencias
                </a>
        </p>
    @endif


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
