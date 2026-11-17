@extends('layouts.app')

@section('title', 'Inicio de sesión')

@section('content')

<div class="card auth-card">

    <h2 class="page-title">
        Inicio de sesión
    </h2>

    @if ($errors->any())

        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    @endif

    <form
        method="POST"
        action="{{ route('login.authenticate') }}"
    >
        @csrf

        <div class="form-group-spacing">

            <label
                for="email"
                class="form-label"
            >
                Correo electrónico
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
            >

        </div>

        <div class="form-group-spacing">

            <label
                for="password"
                class="form-label"
            >
                Contraseña
            </label>

            <input
                type="password"
                id="password"
                name="password"
                required
            >

        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Iniciar sesión
        </button>

    </form>

</div>

@endsection