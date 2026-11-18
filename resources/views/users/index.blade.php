@extends('layouts.app')

@section('title', 'Gestión de usuarios')

@section('content')

<div class="page-header">

    <div>
        <h2 class="page-title">
            Gestión de usuarios
        </h2>

        <p class="page-subtitle">
            Consulte, filtre y administre las cuentas del sistema.
        </p>
    </div>

    <div class="actions">
        <a
            href="{{ route('dashboard') }}"
            class="btn btn-secondary"
        >
            Volver al panel
        </a>

        <a
            href="{{ route('usuarios.create') }}"
            class="btn btn-primary"
        >
            + Nuevo usuario
        </a>
    </div>

</div>

<div class="card">

    <form
        method="GET"
        action="{{ route('usuarios.index') }}"
        class="filters-grid"
    >

        <div>
            <label
                for="buscar"
                class="form-label"
            >
                Buscar
            </label>

            <input
                type="search"
                id="buscar"
                name="buscar"
                value="{{ request('buscar') }}"
                placeholder="Nombre o correo"
            >
        </div>

        <div>
            <label
                for="role_id"
                class="form-label"
            >
                Rol
            </label>

            <select
                id="role_id"
                name="role_id"
            >
                <option value="">
                    Todos
                </option>

                @foreach($roles as $role)
                    <option
                        value="{{ $role->id }}"
                        {{ (string) request('role_id') === (string) $role->id ? 'selected' : '' }}
                    >
                        {{ $role->nombre }}
                    </option>
                @endforeach

            </select>
        </div>

        <div>
            <label
                for="estado"
                class="form-label"
            >
                Estado
            </label>

            <select
                id="estado"
                name="estado"
            >
                <option value="">
                    Todos
                </option>

                <option
                    value="activo"
                    {{ request('estado') === 'activo' ? 'selected' : '' }}
                >
                    Activos
                </option>

                <option
                    value="inactivo"
                    {{ request('estado') === 'inactivo' ? 'selected' : '' }}
                >
                    Inactivos
                </option>
            </select>
        </div>

        <div class="form-actions">
            <button
                type="submit"
                class="btn btn-primary"
            >
                Aplicar
            </button>

            <a
                href="{{ route('usuarios.index') }}"
                class="btn btn-secondary"
            >
                Limpiar
            </a>
        </div>

    </form>

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Último acceso</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                @forelse($users as $user)

                    <tr>

                        <td>
                            {{ $user->name }}
                        </td>

                        <td>
                            {{ $user->email }}
                        </td>

                        <td>
                            {{ $user->role?->nombre ?? 'Sin rol' }}
                        </td>

                        <td>
                            @if($user->activo)

                                <span class="badge badge-success">
                                    Activo
                                </span>

                            @else

                                <span class="badge badge-danger">
                                    Inactivo
                                </span>

                            @endif
                        </td>

                        <td>
                            {{ $user->ultimo_acceso?->format('d/m/Y H:i') ?? 'Nunca' }}
                        </td>

                        <td>

                            <div class="table-actions">

                                <a
                                    href="{{ route('usuarios.edit', $user) }}"
                                    class="btn btn-primary"
                                >
                                    Editar
                                </a>

                                @if($user->activo)

                                    <form
                                        action="{{ route('usuarios.desactivar', $user) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="btn btn-warning"
                                            onclick="return confirm('¿Desactivar este usuario?')"
                                        >
                                            Desactivar
                                        </button>
                                    </form>

                                @else

                                    <form
                                        action="{{ route('usuarios.activar', $user) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                        >
                                            Activar
                                        </button>
                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="6"
                            class="empty-state"
                        >
                            No se encontraron usuarios con los criterios seleccionados.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="section-spacing">
        {{ $users->links() }}
    </div>

</div>

@endsection
