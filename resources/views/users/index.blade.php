<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; color: white; }
        .btn-primary { background-color: #0066cc; }
        .btn-edit { background-color: #009900; }
        .btn-activar { background-color: #009900; }
        .btn-desactivar { background-color: #cc6600; }
        .alert-success { background-color: #d4edda; color: #155724; padding: 10px; border-radius: 3px; margin-bottom: 15px; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 3px; margin-bottom: 15px; border: 1px solid #f5c6cb; }
        .estado-activo { color: green; font-weight: bold; }
        .estado-inactivo { color: red; font-weight: bold; }
        .acciones form { display: inline; }
        .acciones button { border: none; cursor: pointer; padding: 5px 10px; border-radius: 3px; color: white; }
    </style>
</head>
<body>

    <h1>Gestión de Usuarios</h1>

    <p>
        <a href="{{ route('dashboard') }}">← Volver al Panel</a> |
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">+ Nuevo Usuario</a>
    </p>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

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
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role?->nombre ?? 'Sin rol' }}</td>
                    <td>
                        @if($user->activo)
                            <span class="estado-activo">Activo</span>
                        @else
                            <span class="estado-inactivo">Inactivo</span>
                        @endif
                    </td>
                    <td>{{ $user->ultimo_acceso?->format('d/m/Y H:i') ?? 'Nunca' }}</td>
                    <td class="acciones">
                        <a href="{{ route('usuarios.edit', $user) }}" class="btn btn-edit">Editar</a>

                        @if($user->activo)
                            <form action="{{ route('usuarios.desactivar', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-desactivar"
                                        onclick="return confirm('¿Desactivar este usuario?')">
                                    Desactivar
                                </button>
                            </form>
                        @else
                            <form action="{{ route('usuarios.activar', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-activar">Activar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">No hay usuarios registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>

</body>
</html>


