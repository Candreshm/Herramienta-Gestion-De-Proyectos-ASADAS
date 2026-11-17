@extends('layouts.app')

@section('title', 'Editar proyecto')

@section('content')

<div class="page-header">

    <div>
        <h2 class="page-title">
            Editar proyecto
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

            <strong>
                Revise los siguientes campos:
            </strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    <form
        action="{{ route('proyectos.update', $proyecto) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

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
                name="codigo"
                id="codigo"
                value="{{ old('codigo', $proyecto->codigo) }}"
                maxlength="50"
                required
            >

        </div>

        <div class="form-group">

            <label
                for="nombre"
                class="form-label"
            >
                Nombre del proyecto
                <span class="form-required">*</span>
            </label>

            <input
                type="text"
                name="nombre"
                id="nombre"
                value="{{ old('nombre', $proyecto->nombre) }}"
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
                name="descripcion"
                id="descripcion"
                required
            >{{ old('descripcion', $proyecto->descripcion) }}</textarea>

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
                name="objetivo"
                id="objetivo"
                required
            >{{ old('objetivo', $proyecto->objetivo) }}</textarea>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Guardar cambios
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