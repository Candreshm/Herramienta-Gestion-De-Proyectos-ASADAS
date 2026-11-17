@extends('layouts.app')

@section('title', 'Información complementaria')

@section('content')

<div class="page-header">
    <div>
        <h2 class="page-title">
            Información complementaria
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

    @if($errors->any())
        <div class="alert alert-error">
            <strong>Se encontraron los siguientes errores:</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('proyectos.hu05.update', $proyecto) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="form-group">
            <label
                for="justificacion"
                class="form-label"
            >
                Justificación
            </label>

            <textarea
                id="justificacion"
                name="justificacion"
                required
            >{{ old('justificacion', $proyecto->justificacion) }}</textarea>
        </div>

        <div class="form-group">
            <label
                for="costo_estimado"
                class="form-label"
            >
                Costo estimado
            </label>

            <input
                type="number"
                id="costo_estimado"
                name="costo_estimado"
                value="{{ old('costo_estimado', $proyecto->costo_estimado) }}"
                min="0"
                step="0.01"
                required
            >
        </div>

        <div class="form-group">
            <label
                for="impacto_esperado"
                class="form-label"
            >
                Impacto esperado
            </label>

            <textarea
                id="impacto_esperado"
                name="impacto_esperado"
                required
            >{{ old('impacto_esperado', $proyecto->impacto_esperado) }}</textarea>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label
                    for="nivel_riesgo"
                    class="form-label"
                >
                    Nivel de riesgo
                </label>

                <select
                    id="nivel_riesgo"
                    name="nivel_riesgo"
                    required
                >
                    <option value="">Seleccione...</option>

                    @foreach(['Bajo', 'Medio', 'Alto'] as $valor)
                        <option
                            value="{{ $valor }}"
                            {{ old('nivel_riesgo', $proyecto->nivel_riesgo) === $valor ? 'selected' : '' }}
                        >
                            {{ $valor }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label
                    for="criticidad"
                    class="form-label"
                >
                    Criticidad
                </label>

                <select
                    id="criticidad"
                    name="criticidad"
                    required
                >
                    <option value="">Seleccione...</option>

                    @foreach(['Baja', 'Media', 'Alta'] as $valor)
                        <option
                            value="{{ $valor }}"
                            {{ old('criticidad', $proyecto->criticidad) === $valor ? 'selected' : '' }}
                        >
                            {{ $valor }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="form-group">
            <label
                for="prioridad"
                class="form-label"
            >
                Prioridad
            </label>

            <select
                id="prioridad"
                name="prioridad"
                required
            >
                <option value="">Seleccione...</option>

                @foreach(['Baja', 'Media', 'Alta'] as $valor)
                    <option
                        value="{{ $valor }}"
                        {{ old('prioridad', $proyecto->prioridad) === $valor ? 'selected' : '' }}
                    >
                        {{ $valor }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label
                for="evidencia"
                class="form-label"
            >
                Evidencia inicial
            </label>

            <input
                type="file"
                id="evidencia"
                name="evidencia"
            >

            <p class="form-help">
                Puede adjuntar un archivo de evidencia de hasta 10 MB.
            </p>
        </div>

        <div class="form-actions">
            <button
                type="submit"
                class="btn btn-success"
            >
                Guardar información
            </button>

            <a
                href="{{ route('proyectos.show', $proyecto) }}"
                class="btn btn-secondary"
            >
                Cancelar
            </a>
        </div>

    </form>

</div>

@endsection