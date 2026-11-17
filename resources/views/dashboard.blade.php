@extends('layouts.app')

@section('title', 'Panel principal')

@section('content')

    <h2 class="page-title">
        Panel principal
    </h2>

    <div class="card">

        <p>
            Bienvenido,
            <strong>{{ auth()->user()->name }}</strong>
        </p>

        <p>
            Rol:
            <strong>
                {{ auth()->user()->role->nombre ?? 'Sin rol' }}
            </strong>
        </p>

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

        </div>

    </div>

@endsection