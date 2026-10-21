@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar proyecto</h1>

    <p>Modificá los datos generales de la iniciativa registrada.</p>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Revisá los siguientes campos:</strong>
            <ul>
                @foreach ($errors->all() as $error)
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

        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input
                type="text"
                name="codigo"
                id="codigo"
                class="form-control"
                value="{{ old('codigo', $proyecto->codigo) }}"
                maxlength="50"
                required
            >
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del proyecto</label>
            <input
                type="text"
                name="nombre"
                id="nombre"
                class="form-control"
                value="{{ old('nombre', $proyecto->nombre) }}"
                maxlength="255"
                required
            >
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea
                name="descripcion"
                id="descripcion"
                class="form-control"
                rows="4"
                required
            >{{ old('descripcion', $proyecto->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="objetivo" class="form-label">Objetivo</label>
            <textarea
                name="objetivo"
                id="objetivo"
                class="form-control"
                rows="4"
                required
            >{{ old('objetivo', $proyecto->objetivo) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Guardar cambios
        </button>

        <a
            href="{{ route('proyectos.show', $proyecto) }}"
            class="btn btn-secondary"
        >
            Cancelar
        </a>
    </form>
</div>
@endsection
