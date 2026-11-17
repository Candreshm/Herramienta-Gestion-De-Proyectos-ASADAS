@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')

<div class="page-header">

    <div>

        <h2 class="page-title">
            Editar usuario
        </h2>

        <p class="page-subtitle">
            {{ $user->name }} — {{ $user->email }}
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
        action="{{ route('usuarios.update', $user) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

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
                value="{{ old('name', $user->name) }}"
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
                value="{{ old('email', $user->email) }}"
                required
            >

        </div>

        <div class="form-grid">

            <div class="form-group">

                <label
                    for="password"
                    class="form-label"
                >
                    Nueva contraseña
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                >

                <p class="form-help">
                    Déjela en blanco para mantener la contraseña actual.
                </p>

            </div>

            <div class="form-group">

                <label
                    for="password_confirmation"
                    class="form-label"
                >
                    Confirmar nueva contraseña
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
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

                @foreach($roles as $role)

                    <option
                        value="{{ $role->id }}"
                        {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}
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
                    {{ old('activo', $user->activo) ? 'checked' : '' }}
                >

                <span>
                    Usuario activo
                </span>

            </label>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Guardar cambios
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

