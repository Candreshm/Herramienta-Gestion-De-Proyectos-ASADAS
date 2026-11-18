@extends('layouts.app')

@section('title', 'Evaluar proyecto')

@section('content')

<div class="page-header">

    <div>
        <h2 class="page-title">
            Evaluación del proyecto
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

    <p class="form-help">
        Asigne una puntuación del 1 al 5 a cada criterio.
        Todos los criterios son obligatorios.
    </p>

    @if($errors->any())

        <div class="alert alert-error">

            <strong>
                Revise los siguientes errores:
            </strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    <form
        action="{{ route('proyectos.evaluacion.store', $proyecto) }}"
        method="POST"
    >
        @csrf

        <div class="form-group">

            <label
                for="fecha_evaluacion"
                class="form-label"
            >
                Fecha de evaluación
                <span class="form-required">*</span>
            </label>

            <input
                type="date"
                id="fecha_evaluacion"
                name="fecha_evaluacion"
                value="{{ old('fecha_evaluacion', now()->toDateString()) }}"
                required
            >

        </div>

        <h3 class="section-title section-spacing">
            Criterios de evaluación
        </h3>

        @php
            $criterios = [
                'tecnico' => 'Técnico',
                'financiero' => 'Financiero',
                'operativo' => 'Operativo',
                'normativo' => 'Normativo',
            ];
        @endphp

        <div class="criteria-grid">

            @foreach($criterios as $clave => $nombre)

                <div class="criteria-card">

                    <div class="form-group">

                        <label
                            for="criterio_{{ $clave }}"
                            class="form-label"
                        >
                            {{ $nombre }}
                        </label>

                        <select
                            id="criterio_{{ $clave }}"
                            name="criterios[{{ $clave }}]"
                            required
                        >
                            <option value="">
                                Seleccione una puntuación
                            </option>

                            @for($puntuacion = 1; $puntuacion <= 5; $puntuacion++)

                                <option
                                    value="{{ $puntuacion }}"
                                    @selected(
                                        old('criterios.' . $clave) == $puntuacion
                                    )
                                >
                                    {{ $puntuacion }} -

                                    @switch($puntuacion)

                                        @case(1)
                                            Muy bajo
                                            @break

                                        @case(2)
                                            Bajo
                                            @break

                                        @case(3)
                                            Medio
                                            @break

                                        @case(4)
                                            Alto
                                            @break

                                        @case(5)
                                            Muy alto
                                            @break

                                    @endswitch
                                </option>

                            @endfor

                        </select>

                    </div>

                </div>

            @endforeach

        </div>

        <div class="form-group section-spacing">

            <label
                for="observaciones"
                class="form-label"
            >
                Observaciones generales
            </label>

            <textarea
                id="observaciones"
                name="observaciones"
            >{{ old('observaciones') }}</textarea>

            <p class="form-help">
                Campo opcional.
            </p>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Guardar evaluación
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