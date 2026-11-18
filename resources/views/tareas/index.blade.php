<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tablero de tareas - {{ $proyecto->nombre }}</title>
    <style>
        body { font-family: Arial; margin: 20px; max-width: 1200px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .tablero { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .columna { border: 1px solid #ccc; padding: 15px; background: #f9f9f9; border-radius: 5px; }
        .columna h3 { margin-top: 0; }
        .tarea { background: white; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 3px; cursor: move; }
        .tarea-nombre { font-weight: bold; }
        .tarea-responsable { font-size: 0.85em; color: #666; }
        .tarea-fecha { font-size: 0.8em; color: #999; }
        .btn { padding: 8px 12px; text-decoration: none; border-radius: 3px; display: inline-block; }
        .btn-primary { background: #0066cc; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-small { padding: 4px 8px; font-size: 0.85em; }
        .acciones { margin-top: 10px; }
        .alert-success { background: #d4edda; color: #155724; padding: 10px; border-radius: 3px; margin-bottom: 15px; }
        .tarea-meta { display: flex; justify-content: space-between; font-size: 0.8em; margin-top: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Tablero de tareas - {{ $proyecto->codigo }} {{ $proyecto->nombre }}</h1>
        <div>
            <a href="{{ route('tareas.create', $proyecto) }}" class="btn btn-primary">+ Crear tarea</a>
            <a href="{{ route('proyectos.show', $proyecto) }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 3px; margin-bottom: 15px;">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="tablero">
        @foreach ($estados as $estado)
            <div class="columna">
                <h3>{{ $estado }}</h3>
                <div class="tareas" data-estado="{{ $estado }}">
                    @forelse ($proyecto->tareas->where('estado', $estado) as $tarea)
                        <div class="tarea" data-id="{{ $tarea->id }}">
                            <div class="tarea-nombre">{{ $tarea->nombre }}</div>
                            <div class="tarea-responsable">👤 {{ $tarea->responsable->name }}</div>
                            <div class="tarea-fecha">📅 {{ $tarea->fecha_vencimiento->format('d/m/Y H:i') }}</div>
                            <div class="tarea-meta">
                                <span>{{ substr($tarea->descripcion, 0, 30) }}...</span>
                            </div>
                            <div class="acciones">
                                <a href="{{ route('tareas.edit', [$proyecto, $tarea]) }}" class="btn btn-secondary btn-small">Editar</a>
                                <form action="{{ route('tareas.destroy', [$proyecto, $tarea]) }}" method="POST" style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-small" onclick="return confirm('¿Deseas eliminar esta tarea?');">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p style="color: #999;">No hay tareas en este estado.</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
