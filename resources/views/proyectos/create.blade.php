@extends('layouts.app')

@section('title', 'Registrar iniciativa')

@section('content')

<div class="page-header">
    <div>
        <h2 class="page-title">Registrar nueva iniciativa</h2>
        <p class="page-subtitle">
            Complete la información básica para registrar un nuevo proyecto.
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
        action="{{ route('proyectos.store') }}"
        method="POST"
    >
        @csrf

        <div class="form-group">
            <label
                for="codigo"
                class="form-label"
            >
                Código
                <span class="form-required">*</span>
            </label>

            <input
                type="text"
                id="codigo"
                name="codigo"
                value="{{ old('codigo') }}"
                maxlength="50"
                required
            >

            <p class="form-help">
                El código debe identificar de forma única la iniciativa.
            </p>
        </div>

        <div class="form-group">
            <label
                for="nombre"
                class="form-label"
            >
                Nombre de la iniciativa
                <span class="form-required">*</span>
            </label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                value="{{ old('nombre') }}"
                maxlength="255"
                required
            >
        </div>

        <div class="form-group">
            <label
                for="descripcion"
                class="form-label"
            >
                Descripción
                <span class="form-required">*</span>
            </label>

            <textarea
                id="descripcion"
                name="descripcion"
                required
            >{{ old('descripcion') }}</textarea>
        </div>

        <div class="form-group">
            <label
                for="objetivo"
                class="form-label"
            >
                Objetivo
                <span class="form-required">*</span>
            </label>

            <textarea
                id="objetivo"
                name="objetivo"
                required
            >{{ old('objetivo') }}</textarea>
        </div>

        <div class="form-actions">
            <button
                type="submit"
                class="btn btn-primary"
            >
                Registrar iniciativa
            </button>

            <a
                href="{{ route('proyectos.index') }}"
                class="btn btn-secondary"
            >
                Cancelar
            </a>
        </div>

    </form>
</div>

@endsection