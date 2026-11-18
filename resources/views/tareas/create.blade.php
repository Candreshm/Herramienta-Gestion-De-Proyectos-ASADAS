<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear tarea - {{ $proyecto->nombre }}</title>
    <style>
        body { font-family: Arial; margin: 20px; max-width: 600px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 3px; box-sizing: border-box; font-family: Arial; }
        textarea { resize: vertical; min-height: 100px; }
        .btn { padding: 10px 15px; text-decoration: none; border-radius: 3px; display: inline-block; border: none; cursor: pointer; }
        .btn-primary { background: #0066cc; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .errors { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 3px; margin-bottom: 15px; }
        .errors ul { margin: 0; padding-left: 20px; }
        h1 { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Crear tarea - {{ $proyecto->codigo }}</h1>

    @if ($errors->any())
        <div class="errors">
            <strong>Errores de validación:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('tareas.store', $proyecto) }}">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre de la tarea *</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
            @error('nombre') <span style="color: #dc3545; font-size: 0.85em;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción *</label>
            <textarea name="descripcion" id="descripcion" required>{{ old('descripcion') }}</textarea>
            @error('descripcion') <span style="color: #dc3545; font-size: 0.85em;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="fecha_vencimiento">Fecha de vencimiento (YYYY-MM-DD HH:mm) *</label>
            <input type="datetime-local" name="fecha_vencimiento" id="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}" required>
            @error('fecha_vencimiento') <span style="color: #dc3545; font-size: 0.85em;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="responsable_id">Responsable *</label>
            <select name="responsable_id" id="responsable_id" required>
                <option value="">-- Seleccionar responsable --</option>
                @foreach ($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('responsable_id') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
            @error('responsable_id') <span style="color: #dc3545; font-size: 0.85em;">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Crear tarea</button>
            <a href="{{ route('tareas.index', $proyecto) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</body>
</html>
