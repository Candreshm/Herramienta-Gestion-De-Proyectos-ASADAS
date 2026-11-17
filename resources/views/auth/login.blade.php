@extends('layouts.app')

@section('title', 'Inicio de sesión')

@section('content')

<div
    class="card"
    style="max-width: 500px; margin: 60px auto;"
>
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

        <div style="margin-bottom: 18px;">
            <label for="email">
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

        <div style="margin-bottom: 18px;">
            <label for="password">
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