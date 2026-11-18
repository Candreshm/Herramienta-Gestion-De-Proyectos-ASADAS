@extends('layouts.app')

@section('title', 'Registrar usuario')

@section('content')

<div class="page-header">

    <div>
        <h2 class="page-title">
            Registrar nuevo usuario
        </h2>

        <p class="page-subtitle">
            Cree una cuenta y asigne el rol correspondiente.
        </p>
    </div>

    <a
        href="{{ route('usuarios.index') }}"
        class="btn btn-secondary"
    >
        Volver al listado
    </a>

</div>

<div class="card">

    @if($errors->any())

        <div class="alert alert-error">

            <strong>
                Se encontraron los siguientes errores:
            </strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    <form
        action="{{ route('usuarios.store') }}"
        method="POST"
    >
        @csrf

        <div class="form-group">

            <label
                for="name"
                class="form-label"
            >
                Nombre completo
                <span class="form-required">*</span>
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
            >

        </div>

        <div class="form-group">

            <label
                for="email"
                class="form-label"
            >
                Correo electrónico
                <span class="form-required">*</span>
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
            >

        </div>

        <div class="form-grid">

            <div class="form-group">

                <label
                    for="password"
                    class="form-label"
                >
                    Contraseña
                    <span class="form-required">*</span>
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >

                <p class="form-help">
                    Mínimo 8 caracteres.
                </p>

            </div>

            <div class="form-group">

                <label
                    for="password_confirmation"
                    class="form-label"
                >
                    Confirmar contraseña
                    <span class="form-required">*</span>
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                >

            </div>

        </div>

        <div class="form-group">

            <label
                for="role_id"
                class="form-label"
            >
                Rol
                <span class="form-required">*</span>
            </label>

            <select
                id="role_id"
                name="role_id"
                required
            >
                <option value="">
                    Seleccione un rol
                </option>

                @foreach($roles as $role)

                    <option
                        value="{{ $role->id }}"
                        {{ old('role_id') == $role->id ? 'selected' : '' }}
                    >
                        {{ $role->nombre }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="form-group">

            <label class="checkbox-field">

                <input
                    type="checkbox"
                    name="activo"
                    value="1"
                    {{ old('activo', true) ? 'checked' : '' }}
                >

                <span>
                    Usuario activo desde su creación
                </span>

            </label>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Registrar usuario
            </button>

            <a
                href="{{ route('usuarios.index') }}"
                class="btn btn-secondary"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

@endsection
