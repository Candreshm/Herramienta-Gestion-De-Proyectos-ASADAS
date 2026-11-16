<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar hito</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f9; }
        .contenedor { max-width: 700px; margin: auto; background: white; padding: 25px; border-radius: 8px; }
        h1 { color: #263746; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 10px; margin-top: 6px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        textarea { min-height: 100px; }
        .btn { display: inline-block; padding: 10px 15px; border-radius: 5px; text-decoration: none; color: white; margin-top: 18px; border: none; cursor: pointer; }
        .btn-primary { background: #1769aa; }
        .btn-secondary { background: #6c757d; }
        .error { color: #b02a37; font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Editar hito</h1>
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

    <form action="{{ route('proyectos.hitos.update', [$proyecto, $hito]) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nombre">Nombre del hito</label>
        <input type="text" id="nombre" name="nombre"
               value="{{ old('nombre', $hito->nombre) }}" maxlength="150" required>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion">{{ old('descripcion', $hito->descripcion) }}</textarea>

        <label for="fecha_planificada">Fecha planificada</label>
        <input type="date" id="fecha_planificada" name="fecha_planificada"
               value="{{ old('fecha_planificada', $hito->fecha_planificada->format('Y-m-d')) }}"
               required>

        <label for="estado">Estado</label>
        <select id="estado" name="estado" required>
            @foreach(['Pendiente', 'En progreso', 'Completado', 'Atrasado'] as $estado)
                <option value="{{ $estado }}"
                    {{ old('estado', $hito->estado) === $estado ? 'selected' : '' }}>
                    {{ $estado }}
                </option>
            @endforeach
        </select>

        <label for="fecha_cumplimiento">Fecha de cumplimiento</label>
        <input type="date" id="fecha_cumplimiento" name="fecha_cumplimiento"
               value="{{ old('fecha_cumplimiento', $hito->fecha_cumplimiento?->format('Y-m-d')) }}">

        <button type="submit" class="btn btn-primary">Actualizar hito</button>

        <a href="{{ route('proyectos.hitos.index', $proyecto) }}"
           class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
