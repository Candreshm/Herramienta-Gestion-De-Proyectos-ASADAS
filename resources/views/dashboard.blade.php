<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel principal</title>
</head>

<body>

    <h1>Panel principal</h1>

    <p>
        Bienvenido, {{ auth()->user()->name }}
    </p>

    <p>
        Rol:
        {{ auth()->user()->role->nombre ?? 'Sin rol' }}
    </p>

    @if(auth()->user()->role?->nombre === 'Administrador')
        <p>
            <a href="{{ route('usuarios.index') }}">Gestión de Usuarios</a>
        </p>
    @endif

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            Cerrar sesión
        </button>
    </form>

</body>
</html>
