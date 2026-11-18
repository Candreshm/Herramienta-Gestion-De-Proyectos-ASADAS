@extends('layouts.app')

@section('title', 'Detalle de iniciativa')

@section('content')

<div class="page-header">
    <div>
        <h2 class="page-title">
            Detalle de la iniciativa
        </h2>

        <p class="page-subtitle">
            {{ $proyecto->codigo }} — {{ $proyecto->nombre }}
        </p>
    </div>

    <a
        href="{{ route('proyectos.index') }}"
        class="btn btn-secondary"
    >
        Volver al listado
    </a>
</div>

<div class="card">

    <h3 class="section-title">
        Información general
    </h3>

    <div class="detail-grid">

        <div class="detail-field">
            <span class="detail-label">Código</span>
            <div class="detail-value">
                {{ $proyecto->codigo }}
            </div>
        </div>

        <div class="detail-field">
            <span class="detail-label">Estado</span>

            <div class="detail-value">
                <span class="badge badge-success">
                    {{ $proyecto->estado?->nombre ?? 'Sin estado' }}
                </span>
            </div>
        </div>

        <div class="detail-field detail-field-full">
            <span class="detail-label">
                Nombre de la iniciativa
            </span>

            <div class="detail-value">
                {{ $proyecto->nombre }}
            </div>
        </div>

        <div class="detail-field detail-field-full">
            <span class="detail-label">
                Descripción
            </span>

            <div class="detail-value">
                {{ $proyecto->descripcion }}
            </div>
        </div>

        <div class="detail-field detail-field-full">
            <span class="detail-label">
                Objetivo
            </span>

            <div class="detail-value">
                {{ $proyecto->objetivo }}
            </div>
        </div>

        <div class="detail-field">
            <span class="detail-label">
                Registrado por
            </span>

            <div class="detail-value">
                {{ $proyecto->creador?->name ?? 'Sin usuario' }}
            </div>
        </div>

        <div class="detail-field">
            <span class="detail-label">
                Fecha de registro
            </span>

            <div class="detail-value">
                {{ $proyecto->created_at?->format('d/m/Y H:i') }}
            </div>
        </div>

    </div>

</div>

<div class="card section-spacing">

    <h3 class="section-title">
        Información complementaria
    </h3>

    <div class="detail-grid">

        <div class="detail-field detail-field-full">
            <span class="detail-label">
                Justificación
            </span>

            <div class="detail-value">
                {{ $proyecto->justificacion ?: 'No registrada' }}
            </div>
        </div>

        <div class="detail-field">
            <span class="detail-label">
                Costo estimado
            </span>

            <div class="detail-value">
                @if($proyecto->costo_estimado !== null)
                    ₡{{ number_format($proyecto->costo_estimado, 2) }}
                @else
                    No registrado
                @endif
            </div>
        </div>

        <div class="detail-field">
            <span class="detail-label">
                Nivel de riesgo
            </span>

            <div class="detail-value">
                {{ $proyecto->nivel_riesgo ?: 'No registrado' }}
            </div>
        </div>

        <div class="detail-field detail-field-full">
            <span class="detail-label">
                Impacto esperado
            </span>

            <div class="detail-value">
                {{ $proyecto->impacto_esperado ?: 'No registrado' }}
            </div>
        </div>

        <div class="detail-field">
            <span class="detail-label">
                Criticidad
            </span>

            <div class="detail-value">
                {{ $proyecto->criticidad ?: 'No registrada' }}
            </div>
        </div>

        <div class="detail-field">
            <span class="detail-label">
                Prioridad
            </span>

            <div class="detail-value">
                {{ $proyecto->prioridad ?: 'No registrada' }}
            </div>
        </div>

    </div>

    <div class="form-actions">

        @if (!in_array($proyecto->estado?->nombre, ['Aprobado', 'Finalizado'], true))
            <a
                href="{{ route('proyectos.edit', $proyecto) }}"
                class="btn btn-primary"
            >
                Editar proyecto
            </a>
        @endif

        <a
            href="{{ route('proyectos.hu05.edit', $proyecto) }}"
            class="btn btn-success"
        >
            Completar información
        </a>

        <a
            href="{{ route('proyectos.evaluacion.create', $proyecto) }}"
            class="btn btn-primary"
        >
            Registrar evaluación
        </a>

        <a
            href="{{ route(
                'presupuesto.validacion.edit',
                $proyecto
            ) }}"
            class="btn btn-primary"
        >
            Validar presupuesto
        </a>

        <a
    href="{{ route(
        'proyectos.aprobacion.edit',
        $proyecto
    ) }}"
    class="btn btn-warning"
>
    Aprobar / rechazar
</a>
<a
    href="{{ route(
        'proyectos.tareas.index',
        $proyecto
    ) }}"
    class="btn btn-primary"
>
    Tablero de tareas
</a>

<a
    href="{{ route(
        'proyectos.seguimiento.index',
        $proyecto
    ) }}"
    class="btn btn-primary"
>
    Seguimiento
</a>

<a
    href="{{ route(
        'proyectos.documentos.index',
        $proyecto
    ) }}"
    class="btn btn-primary"
>
    Expediente documental
</a>
        <a
            href="{{ route('proyectos.evaluacion.index', $proyecto) }}"
            class="btn btn-secondary"
        >
            Historial de evaluaciones
        </a>

    </div>

</div>

<div class="card section-spacing">

    <h3 class="section-title">
        Evidencia inicial
    </h3>

    @if($proyecto->evidencias->count() > 0)

        <ul class="file-list">

            @foreach($proyecto->evidencias as $evidencia)

                <li>
                    <a
                        href="{{ asset('storage/' . $evidencia->ruta) }}"
                        target="_blank"
                    >
                        {{ $evidencia->nombre_original }}
                    </a>

                    <span class="file-meta">
                        ({{ number_format(($evidencia->tamano ?? 0) / 1024, 2) }} KB)
                    </span>
                </li>

            @endforeach

        </ul>

    @else

        <p class="form-help">
            No se ha registrado evidencia inicial.
        </p>

    @endif

</div>

@endsection