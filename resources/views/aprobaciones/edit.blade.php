@extends('layouts.app')

@section('title', 'Aprobación del proyecto')

@section('content')

<div class="page-header">

    <div>
        <h2 class="page-title">
            Aprobación del proyecto
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
        Condiciones para aprobación
    </h3>

    <div class="detail-grid">

        <div class="detail-field">
            <span class="detail-label">
                Dictamen de viabilidad
            </span>

            <div class="detail-value">
                @if($proyecto->evaluacion?->dictamen === 'Viable')
                    <span class="badge badge-success">
                        Viable
                    </span>
                @elseif($proyecto->evaluacion?->dictamen)
                    <span class="badge badge-danger">
                        {{ $proyecto->evaluacion->dictamen }}
                    </span>
                @else
                    <span class="badge badge-warning">
                        Sin calcular
                    </span>
                @endif
            </div>
        </div>

        <div class="detail-field">
            <span class="detail-label">
                Disponibilidad presupuestaria
            </span>

            <div class="detail-value">

                @if(
                    $proyecto->validacionPresupuestaria &&
                    $proyecto
                        ->validacionPresupuestaria
                        ->tienePresupuestoSuficiente()
                )

                    <span class="badge badge-success">
                        Presupuesto suficiente
                    </span>

                @elseif($proyecto->validacionPresupuestaria)

                    <span class="badge badge-danger">
                        Presupuesto insuficiente
                    </span>

                @else

                    <span class="badge badge-warning">
                        Sin validar
                    </span>

                @endif

            </div>
        </div>

    </div>

</div>

<div class="card section-spacing">

    <h3 class="section-title">
        Registrar decisión
    </h3>

    <form
        method="POST"
        action="{{ route('proyectos.aprobacion.update', $proyecto) }}"
    >
        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group">

                <label
                    for="decision"
                    class="form-label"
                >
                    Decisión
                </label>

                <select
                    id="decision"
                    name="decision"
                    required
                >
                    <option value="">
                        Seleccione
                    </option>

                    <option
                        value="Aprobado"
                        @selected(
                            old(
                                'decision',
                                $proyecto->aprobacion?->decision
                            ) === 'Aprobado'
                        )
                    >
                        Aprobar
                    </option>

                    <option
                        value="Rechazado"
                        @selected(
                            old(
                                'decision',
                                $proyecto->aprobacion?->decision
                            ) === 'Rechazado'
                        )
                    >
                        Rechazar
                    </option>
                </select>

            </div>

            <div class="form-group">

                <label
                    for="numero_acuerdo"
                    class="form-label"
                >
                    Número de acuerdo
                </label>

                <input
                    type="text"
                    id="numero_acuerdo"
                    name="numero_acuerdo"
                    maxlength="100"
                    value="{{ old(
                        'numero_acuerdo',
                        $proyecto->aprobacion?->numero_acuerdo
                    ) }}"
                >

            </div>

            <div class="form-group">

                <label
                    for="fecha_acuerdo"
                    class="form-label"
                >
                    Fecha del acuerdo
                </label>

                <input
                    type="date"
                    id="fecha_acuerdo"
                    name="fecha_acuerdo"
                    value="{{ old(
                        'fecha_acuerdo',
                        $proyecto->aprobacion?->fecha_acuerdo?->format('Y-m-d')
                        ?? now()->format('Y-m-d')
                    ) }}"
                    required
                >

            </div>

            <div class="form-group">

                <label
                    for="responsable"
                    class="form-label"
                >
                    Responsable
                </label>

                <input
                    type="text"
                    id="responsable"
                    name="responsable"
                    maxlength="150"
                    value="{{ old(
                        'responsable',
                        $proyecto->aprobacion?->responsable
                    ) }}"
                    required
                >

            </div>

        </div>

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
                maxlength="5000"
                required
            >{{ old(
                'justificacion',
                $proyecto->aprobacion?->justificacion
            ) }}</textarea>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Guardar decisión
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