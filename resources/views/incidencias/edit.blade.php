<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar incidencia</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f9; }
        .contenedor { max-width: 700px; margin: auto; background: white; padding: 25px; border-radius: 8px; }
        h1 { color: #263746; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 10px; margin-top: 6px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        textarea { min-height: 120px; }
        .btn { display: inline-block; padding: 10px 15px; border-radius: 5px; text-decoration: none; color: white; margin-top: 18px; border: none; cursor: pointer; }
        .btn-primary { background: #1769aa; }
        .btn-secondary { background: #6c757d; }
        .error { color: #b02a37; font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Editar incidencia</h1>
    <h3>Proyecto: {{ $proyecto->nombre }}</h3>

    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proyectos.incidencias.update', [$proyecto, $incidencia]) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="titulo">Título de la incidencia</label>
        <input type="text" id="titulo" name="titulo"
               value="{{ old('titulo', $incidencia->titulo) }}" maxlength="150" required>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion"
                  minlength="10" maxlength="5000" required>{{ old('descripcion', $incidencia->descripcion) }}</textarea>

        <label for="nivel_severidad">Nivel de severidad</label>
        <select id="nivel_severidad" name="nivel_severidad" required>
            @foreach(['Baja', 'Media', 'Alta', 'Crítica'] as $nivel)
                <option value="{{ $nivel }}"
                    {{ old('nivel_severidad', $incidencia->nivel_severidad) === $nivel ? 'selected' : '' }}>
                    {{ $nivel }}
                </option>
            @endforeach
        </select>

        <label for="estado">Estado</label>
        <select id="estado" name="estado" required>
            @foreach(['Abierta', 'En seguimiento', 'Resuelta', 'Cerrada'] as $estado)
                <option value="{{ $estado }}"
                    {{ old('estado', $incidencia->estado) === $estado ? 'selected' : '' }}>
                    {{ $estado }}
                </option>
            @endforeach
        </select>

        <label for="fecha_registro">Fecha de registro</label>
        <input type="date" id="fecha_registro" name="fecha_registro"
               value="{{ old('fecha_registro', $incidencia->fecha_registro->format('Y-m-d')) }}"
               required>

        <label for="fecha_resolucion">Fecha de resolución</label>
        <input type="date" id="fecha_resolucion" name="fecha_resolucion"
               value="{{ old('fecha_resolucion', $incidencia->fecha_resolucion?->format('Y-m-d')) }}">

        <label for="responsable_id">Responsable asignado</label>
        <select id="responsable_id" name="responsable_id">
            <option value="">Sin asignar</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}"
                    {{ (string) old('responsable_id', $incidencia->responsable_id) === (string) $usuario->id ? 'selected' : '' }}>
                    {{ $usuario->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Actualizar incidencia</button>

        <a href="{{ route('proyectos.incidencias.index', $proyecto) }}"
           class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
