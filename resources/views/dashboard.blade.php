@extends('layouts.app')

@section('title', 'Panel principal')

@section('content')

<div class="page-header">
    <div>
        <h2 class="page-title">
            Panel principal
        </h2>

        <p class="page-subtitle">
            Bienvenido, {{ auth()->user()->name }}.
            Rol: {{ auth()->user()->role?->nombre ?? 'Sin rol' }}.
        </p>
    </div>
</div>

<div class="card">

    <h3 class="section-title">
        Gestión del sistema
    </h3>

    <div class="actions">

        @if(auth()->user()->role?->nombre === 'Administrador')

            <a
                href="{{ route('usuarios.index') }}"
                class="btn btn-primary"
            >
                Gestión de usuarios
            </a>

        @endif

        <a
            href="{{ route('proyectos.index') }}"
            class="btn btn-primary"
        >
            Ver iniciativas
        </a>

        <a
            href="{{ route('proyectos.create') }}"
            class="btn btn-success"
        >
            Registrar iniciativa
        </a>

        <a
            href="{{ route('viabilidad.ranking') }}"
            class="btn btn-primary"
        >
            Ranking y viabilidad
        </a>

    </div>

</div>

@endsection