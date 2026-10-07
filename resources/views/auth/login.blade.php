<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
</head>

<body>

    <h1>Herramienta de Gestión de Proyectos para ASADAS</h1>

    <h2>Inicio de sesión</h2>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.authenticate') }}">
        @csrf

        <div>
            <label for="email">Correo electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
            >
        </div>

        <div>
            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                name="password"
            >
        </div>

        <button type="submit">
            Iniciar sesión
        </button>
    </form>

</body>
</html>