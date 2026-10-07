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

    <h2>Gestión de proyectos</h2>

<a href="{{ route('proyectos.index') }}"
   style="display:inline-block;
          padding:10px 15px;
          background:#007bff;
          color:white;
          text-decoration:none;
          border-radius:5px;">
    Ver iniciativas
</a>

<a href="{{ route('proyectos.create') }}"
   style="display:inline-block;
          padding:10px 15px;
          background:#28a745;
          color:white;
          text-decoration:none;
          border-radius:5px;
          margin-left:10px;">
    Registrar iniciativa
</a>

</body>
</html>
