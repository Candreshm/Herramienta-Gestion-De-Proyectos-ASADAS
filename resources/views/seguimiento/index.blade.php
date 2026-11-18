@extends('layouts.app')

@section('title', 'Seguimiento del proyecto')

@section('content')

<div class="page-header">
    <div>
        <h2 class="page-title">Seguimiento del proyecto</h2>

        <p class="page-subtitle">
            {{ $proyecto->codigo }} — {{ $proyecto->nombre }}
        </p>
    </div>

    <a
        href="{{ route('proyectos.show', $proyecto) }}"
        class="btn btn-secondary"
    >
        Volver al proyecto
    </a>
</div>

<div class="card">

    <h3 class="section-title">Hitos</h3>

    <form
        method="POST"
        action="{{ route('proyectos.seguimiento.hitos.store', $proyecto) }}"
    >
        @csrf

        <div class="form-grid">

            <div class="form-group">
                <label class="form-label">Nombre</label>
                <input
                    type="text"
                    name="nombre"
                    maxlength="150"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label">Fecha planificada</label>
                <input
                    type="date"
                    name="fecha_planificada"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label">Responsable</label>

                <select name="responsable_id">
                    <option value="">Sin asignar</option>

                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion"></textarea>
        </div>

        <button class="btn btn-success">
            Registrar hito
        </button>

    </form>

    <div class="section-spacing">

        @forelse($proyecto->hitos as $hito)

            <div class="card">

                <strong>{{ $hito->nombre }}</strong>

                <p class="form-help">
                    Responsable:
                    {{ $hito->responsable?->name ?? 'Sin asignar' }}
                </p>

                <p class="form-help">
                    Fecha planificada:
                    {{ $hito->fecha_planificada->format('d/m/Y') }}
                </p>

                <form
                    method="POST"
                    action="{{ route(
                        'proyectos.seguimiento.hitos.update',
                        [$proyecto, $hito]
                    ) }}"
                >
                    @csrf
                    @method('PATCH')

                    <div class="form-grid">

                        <div class="form-group">
                            <label class="form-label">Estado</label>

                            <select name="estado">
                                @foreach([
                                    'Pendiente',
                                    'En progreso',
                                    'Cumplido',
                                    'Atrasado'
                                ] as $estado)
                                    <option
                                        value="{{ $estado }}"
                                        @selected($hito->estado === $estado)
                                    >
                                        {{ $estado }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Fecha de cumplimiento
                            </label>

                            <input
                                type="date"
                                name="fecha_cumplimiento"
                                value="{{ $hito->fecha_cumplimiento?->format('Y-m-d') }}"
                            >
                        </div>

                    </div>

                    <button class="btn btn-primary">
                        Actualizar hito
                    </button>

                </form>

            </div>

        @empty

            <p class="empty-state">
                No hay hitos registrados.
            </p>

        @endforelse

    </div>

</div>

<div class="card section-spacing">

    <h3 class="section-title">Avances</h3>

    <form
        method="POST"
        action="{{ route(
            'proyectos.seguimiento.avances.store',
            $proyecto
        ) }}"
    >
        @csrf

        <div class="form-grid">

            <div class="form-group">
                <label class="form-label">
                    Porcentaje de avance
                </label>

                <input
                    type="number"
                    name="porcentaje_avance"
                    min="0"
                    max="100"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label">Fecha</label>

                <input
                    type="date"
                    name="fecha"
                    value="{{ now()->format('Y-m-d') }}"
                    required
                >
            </div>

        </div>

        <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" required></textarea>
        </div>

        <button class="btn btn-success">
            Registrar avance
        </button>

    </form>

    <div class="section-spacing">

        @forelse(
            $proyecto->avances->sortByDesc('fecha')
            as $avance
        )

            <div class="detail-field">

                <span class="detail-label">
                    {{ $avance->porcentaje_avance }} %
                    — {{ $avance->fecha->format('d/m/Y') }}
                </span>

                <div class="detail-value">
                    {{ $avance->descripcion }}
                </div>

                <p class="form-help">
                    Registrado por:
                    {{ $avance->registradoPor?->name ?? 'Sin usuario' }}
                </p>

            </div>

        @empty

            <p class="empty-state">
                No hay avances registrados.
            </p>

        @endforelse

    </div>

</div>

<div class="card section-spacing">

    <h3 class="section-title">Incidencias</h3>

    <form
        method="POST"
        action="{{ route(
            'proyectos.seguimiento.incidencias.store',
            $proyecto
        ) }}"
    >
        @csrf

        <div class="form-grid">

            <div class="form-group">
                <label class="form-label">Título</label>

                <input
                    type="text"
                    name="titulo"
                    maxlength="150"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label">Severidad</label>

                <select name="nivel_severidad" required>
                    <option value="Baja">Baja</option>
                    <option value="Media">Media</option>
                    <option value="Alta">Alta</option>
                    <option value="Crítica">Crítica</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Responsable</label>

                <select name="responsable_id">
                    <option value="">Sin asignar</option>

                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">
                    Fecha de registro
                </label>

                <input
                    type="date"
                    name="fecha_registro"
                    value="{{ now()->format('Y-m-d') }}"
                    required
                >
            </div>

        </div>

        <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" required></textarea>
        </div>

        <button class="btn btn-success">
            Registrar incidencia
        </button>

    </form>

    <div class="section-spacing">

        @forelse($proyecto->incidencias as $incidencia)

            <div class="card">

                <strong>
                    {{ $incidencia->titulo }}
                </strong>

                <p>
                    {{ $incidencia->descripcion }}
                </p>

                <p class="form-help">
                    Severidad:
                    {{ $incidencia->nivel_severidad }}
                </p>

                <p class="form-help">
                    Responsable:
                    {{ $incidencia->responsable?->name ?? 'Sin asignar' }}
                </p>

                <form
                    method="POST"
                    action="{{ route(
                        'proyectos.seguimiento.incidencias.update',
                        [$proyecto, $incidencia]
                    ) }}"
                >
                    @csrf
                    @method('PATCH')

                    <div class="form-grid">

                        <div class="form-group">

                            <label class="form-label">
                                Estado
                            </label>

                            <select name="estado">

                                @foreach([
                                    'Abierta',
                                    'En atención',
                                    'Resuelta'
                                ] as $estado)

                                    <option
                                        value="{{ $estado }}"
                                        @selected(
                                            $incidencia->estado === $estado
                                        )
                                    >
                                        {{ $estado }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                Fecha de resolución
                            </label>

                            <input
                                type="date"
                                name="fecha_resolucion"
                                value="{{ $incidencia->fecha_resolucion?->format('Y-m-d') }}"
                            >

                        </div>

                    </div>

                    <button class="btn btn-primary">
                        Actualizar incidencia
                    </button>

                </form>

            </div>

        @empty

            <p class="empty-state">
                No hay incidencias registradas.
            </p>

        @endforelse

    </div>

</div>

@endsection