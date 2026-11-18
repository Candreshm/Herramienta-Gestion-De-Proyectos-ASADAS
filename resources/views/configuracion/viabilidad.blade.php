@extends('layouts.app')

@section('title', 'Modelo de viabilidad')

@section('content')

<div class="page-header">

    <div>
        <h2 class="page-title">
            Modelo de viabilidad
        </h2>

        <p class="page-subtitle">
            Configure las ponderaciones utilizadas para calcular
            automáticamente la viabilidad de los proyectos.
        </p>
    </div>

    <a
        href="{{ route('dashboard') }}"
        class="btn btn-secondary"
    >
        Volver al panel
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
        Configuración activa
    </h3>

    <form
        method="POST"
        action="{{ route('modelo-viabilidad.update') }}"
    >
        @csrf
        @method('PUT')

        <div class="form-group">

            <label
                for="nombre"
                class="form-label"
            >
                Nombre del modelo
            </label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                value="{{ old('nombre', $modelo->nombre) }}"
                maxlength="100"
                required
            >

        </div>

        <div class="form-grid">

            <div class="form-group">

                <label
                    for="peso_tecnico"
                    class="form-label"
                >
                    Peso técnico (%)
                </label>

                <input
                    type="number"
                    id="peso_tecnico"
                    name="peso_tecnico"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{ old('peso_tecnico', $modelo->peso_tecnico) }}"
                    required
                >

            </div>

            <div class="form-group">

                <label
                    for="peso_financiero"
                    class="form-label"
                >
                    Peso financiero (%)
                </label>

                <input
                    type="number"
                    id="peso_financiero"
                    name="peso_financiero"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{ old('peso_financiero', $modelo->peso_financiero) }}"
                    required
                >

            </div>

            <div class="form-group">

                <label
                    for="peso_operativo"
                    class="form-label"
                >
                    Peso operativo (%)
                </label>

                <input
                    type="number"
                    id="peso_operativo"
                    name="peso_operativo"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{ old('peso_operativo', $modelo->peso_operativo) }}"
                    required
                >

            </div>

            <div class="form-group">

                <label
                    for="peso_normativo"
                    class="form-label"
                >
                    Peso normativo (%)
                </label>

                <input
                    type="number"
                    id="peso_normativo"
                    name="peso_normativo"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{ old('peso_normativo', $modelo->peso_normativo) }}"
                    required
                >

            </div>

        </div>

        <div class="form-group">

            <label
                for="umbral_viable"
                class="form-label"
            >
                Umbral mínimo de viabilidad (%)
            </label>

            <input
                type="number"
                id="umbral_viable"
                name="umbral_viable"
                min="0"
                max="100"
                step="0.01"
                value="{{ old('umbral_viable', $modelo->umbral_viable) }}"
                required
            >

            <p class="form-help">
                Los proyectos con un puntaje igual o superior a este
                porcentaje serán clasificados como viables.
            </p>

        </div>

        <div class="detail-field">

            <span class="detail-label">
                Suma actual de ponderaciones
            </span>

            <span class="detail-value">
                {{ number_format($modelo->suma_pesos, 2) }} %
            </span>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Guardar configuración
            </button>

            <a
                href="{{ route('dashboard') }}"
                class="btn btn-secondary"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

@endsection