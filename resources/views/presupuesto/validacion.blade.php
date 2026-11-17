@extends('layouts.app')

@section('title', 'Validación presupuestaria')

@section('content')

<div class="page-header">

    <div>
        <h2 class="page-title">
            Validación presupuestaria
        </h2>

        <p class="page-subtitle">
            Proyecto:
            {{ $proyecto->codigo }}
            —
            {{ $proyecto->nombre }}
        </p>
    </div>

    <a
        href="{{ route('proyectos.show', $proyecto) }}"
        class="btn btn-secondary"
    >
        Volver al proyecto
    </a>

</div>

@if($errors->any())

    <div class="alert alert-error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif

<div class="card">

    <h3 class="section-title">
        Disponibilidad presupuestaria
    </h3>

    <div class="detail-grid">

        <div class="detail-field">

            <span class="detail-label">
                Costo estimado del proyecto
            </span>

            <span class="detail-value">
                ₡{{ number_format(
                    (float) $proyecto->costo_estimado,
                    2,
                    ',',
                    '.'
                ) }}
            </span>

        </div>

        @if($proyecto->validacionPresupuestaria)

            <div class="detail-field">

                <span class="detail-label">
                    Estado actual
                </span>

                <span class="detail-value">

                    @if(
                        $proyecto
                            ->validacionPresupuestaria
                            ->tienePresupuestoSuficiente()
                    )

                        <span class="badge badge-success">
                            Presupuesto suficiente
                        </span>

                    @else

                        <span class="badge badge-danger">
                            Presupuesto insuficiente
                        </span>

                    @endif

                </span>

            </div>

        @endif

    </div>

</div>

<div class="card section-spacing">

    <form
        method="POST"
        action="{{ route(
            'presupuesto.validacion.update',
            $proyecto
        ) }}"
    >
        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group">

                <label
                    for="monto_disponible"
                    class="form-label"
                >
                    Monto disponible
                </label>

                <input
                    type="number"
                    id="monto_disponible"
                    name="monto_disponible"
                    min="0"
                    step="0.01"
                    value="{{ old(
                        'monto_disponible',
                        $proyecto
                            ->validacionPresupuestaria
                            ?->monto_disponible
                    ) }}"
                    required
                >

            </div>

            <div class="form-group">

                <label
                    for="fecha_validacion"
                    class="form-label"
                >
                    Fecha de validación
                </label>

                <input
                    type="date"
                    id="fecha_validacion"
                    name="fecha_validacion"
                    value="{{ old(
                        'fecha_validacion',
                        $proyecto
                            ->validacionPresupuestaria
                            ?->fecha_validacion
                            ?->format('Y-m-d')
                            ?? now()->format('Y-m-d')
                    ) }}"
                    required
                >

            </div>

        </div>

        <div class="form-group">

            <label
                for="observaciones"
                class="form-label"
            >
                Observaciones
            </label>

            <textarea
                id="observaciones"
                name="observaciones"
                maxlength="5000"
            >{{ old(
                'observaciones',
                $proyecto
                    ->validacionPresupuestaria
                    ?->observaciones
            ) }}</textarea>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Guardar validación
            </button>

            <a
                href="{{ route(
                    'proyectos.show',
                    $proyecto
                ) }}"
                class="btn btn-secondary"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

@endsection