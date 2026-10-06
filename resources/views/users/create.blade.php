<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; max-width: 600px; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input, select { width: 100%; padding: 6px; margin-top: 4px; box-sizing: border-box; }
        button, .btn { padding: 8px 15px; margin-top: 15px; border: none; border-radius: 3px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background-color: #0066cc; color: white; }
        .btn-secondary { background-color: #ccc; color: black; }
        .errores { background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 3px; margin-bottom: 15px; }
        .errores ul { margin: 5px 0; padding-left: 20px; }
        .check { width: auto; display: inline; }
    </style>
</head>
<body>

    <h1>Registrar Nuevo Usuario</h1>

    <p><a href="{{ route('usuarios.index') }}">← Volver al listado</a></p>

    @if($errors->any())
        <div class="errores">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <label>Nombre completo *</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label>Correo electrónico *</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Contraseña * (mínimo 8 caracteres)</label>
        <input type="password" name="password" required>

        <label>Confirmar contraseña *</label>
        <input type="password" name="password_confirmation" required>

        <label>Rol *</label>
        <select name="role_id" required>
            <option value="">-- Seleccione un rol --</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                    {{ $role->nombre }}
                </option>
            @endforeach
        </select>

        <label>
            <input type="checkbox" name="activo" value="1" class="check" checked>
            Usuario activo desde su creación
        </label>

        <div>
            <button type="submit" class="btn-primary">Registrar Usuario</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

</body>
</html>

