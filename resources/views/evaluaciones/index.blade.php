@extends('layouts.app')

@section('title', 'Historial de evaluaciones')

@section('content')

<div class="page-header">

    <div>
        <h2 class="page-title">
            Historial de evaluaciones
        </h2>

        <p class="page-subtitle">
            {{ $proyecto->codigo }} — {{ $proyecto->nombre }}
        </p>
    </div>

    <div class="actions">

        <a
            href="{{ route('proyectos.evaluacion.create', $proyecto) }}"
            class="btn btn-primary"
        >
            + Registrar evaluación
        </a>

        <a
            href="{{ route('proyectos.show', $proyecto) }}"
            class="btn btn-secondary"
        >
            Volver al proyecto
        </a>

    </div>

</div>

<div class="card">

    @forelse($evaluaciones as $evaluacion)

        <div class="evaluation-card">

            <div class="evaluation-header">

                <div>

                    <h3 class="evaluation-title">
                        Evaluación del
                        {{ $evaluacion->fecha_evaluacion?->format('d/m/Y') }}
                    </h3>

                    <div class="evaluation-meta">
                        Evaluador:
                        {{ $evaluacion->evaluador?->name ?? 'No disponible' }}
                    </div>

                </div>

            </div>

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>Criterio</th>
                            <th>Puntuación</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($evaluacion->criterios as $criterio)

                            <tr>

                                <td>
                                    {{ $criterio->criterio }}
                                </td>

                                <td>
                                    <span class="score">
                                        {{ $criterio->puntuacion }} / 5
                                    </span>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @if($evaluacion->observaciones)

                <div class="detail-field section-spacing">

                    <span class="detail-label">
                        Observaciones
                    </span>

                    <div class="detail-value">
                        {{ $evaluacion->observaciones }}
                    </div>

                </div>

            @endif

        </div>

    @empty

        <div class="empty-state">
            Este proyecto todavía no tiene evaluaciones registradas.
        </div>

    @endforelse

    @if($evaluaciones->hasPages())

        <div class="section-spacing">
            {{ $evaluaciones->links() }}
        </div>

    @endif

</div>

@endsection