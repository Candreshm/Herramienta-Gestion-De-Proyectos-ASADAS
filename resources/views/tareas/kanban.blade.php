@extends('layouts.app')

@section('title', 'Tablero de tareas')

@section('content')

<div class="page-header">
    <div>
        <h2 class="page-title">
            Tablero Kanban
        </h2>

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

    <h3 class="section-title">
        Nueva tarea
    </h3>

    <form
        method="POST"
        action="{{ route('proyectos.tareas.store', $proyecto) }}"
    >
        @csrf

        <div class="form-grid">

            <div class="form-group">
                <label
                    for="titulo"
                    class="form-label"
                >
                    Título
                </label>

                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    maxlength="150"
                    value="{{ old('titulo') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label
                    for="responsable_id"
                    class="form-label"
                >
                    Responsable
                </label>

                <select
                    id="responsable_id"
                    name="responsable_id"
                >
                    <option value="">
                        Sin asignar
                    </option>

                    @foreach($usuarios as $usuario)
                        <option
                            value="{{ $usuario->id }}"
                            @selected(
                                old('responsable_id') == $usuario->id
                            )
                        >
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label
                    for="fecha_inicio"
                    class="form-label"
                >
                    Fecha de inicio
                </label>

                <input
                    type="date"
                    id="fecha_inicio"
                    name="fecha_inicio"
                    value="{{ old('fecha_inicio') }}"
                >
            </div>

            <div class="form-group">
                <label
                    for="fecha_vencimiento"
                    class="form-label"
                >
                    Fecha de vencimiento
                </label>

                <input
                    type="date"
                    id="fecha_vencimiento"
                    name="fecha_vencimiento"
                    value="{{ old('fecha_vencimiento') }}"
                >
            </div>

        </div>

        <div class="form-group">

            <label
                for="descripcion"
                class="form-label"
            >
                Descripción
            </label>

            <textarea
                id="descripcion"
                name="descripcion"
                maxlength="5000"
            >{{ old('descripcion') }}</textarea>

        </div>

        <div class="form-actions">
            <button
                type="submit"
                class="btn btn-success"
            >
                Crear tarea
            </button>
        </div>

    </form>

</div>

<div class="kanban-grid section-spacing">

    @php
        $columnas = [
            'Pendiente' => $pendientes,
            'En progreso' => $enProgreso,
            'Completada' => $completadas,
        ];
    @endphp

    @foreach($columnas as $estado => $tareas)

        <div class="kanban-column">

            <h3 class="section-title">
                {{ $estado }}
            </h3>

            @forelse($tareas as $tarea)

                <div class="kanban-card">

                    <h4>
                        {{ $tarea->titulo }}
                    </h4>

                    @if($tarea->descripcion)
                        <p>
                            {{ $tarea->descripcion }}
                        </p>
                    @endif

                    <p class="form-help">
                        Responsable:
                        {{ $tarea->responsable?->name ?? 'Sin asignar' }}
                    </p>

                    @if($tarea->fecha_vencimiento)
                        <p class="form-help">
                            Vence:
                            {{ $tarea->fecha_vencimiento->format('d/m/Y') }}
                        </p>
                    @endif

                    <form
                        method="POST"
                        action="{{ route(
                            'proyectos.tareas.estado',
                            [$proyecto, $tarea]
                        ) }}"
                    >
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <select
                                name="estado"
                                required
                            >
                                <option
                                    value="Pendiente"
                                    @selected($tarea->estado === 'Pendiente')
                                >
                                    Pendiente
                                </option>

                                <option
                                    value="En progreso"
                                    @selected($tarea->estado === 'En progreso')
                                >
                                    En progreso
                                </option>

                                <option
                                    value="Completada"
                                    @selected($tarea->estado === 'Completada')
                                >
                                    Completada
                                </option>
                            </select>
                        </div>

                        <div class="form-actions">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Cambiar estado
                            </button>

                        </div>

                    </form>

                    <form
                        method="POST"
                        action="{{ route(
                            'proyectos.tareas.destroy',
                            [$proyecto, $tarea]
                        ) }}"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger"
                            onclick="return confirm('¿Eliminar esta tarea?')"
                        >
                            Eliminar
                        </button>
                    </form>

                </div>

            @empty

                <p class="empty-state">
                    No hay tareas en este estado.
                </p>

            @endforelse

        </div>

    @endforeach

</div>

@endsection