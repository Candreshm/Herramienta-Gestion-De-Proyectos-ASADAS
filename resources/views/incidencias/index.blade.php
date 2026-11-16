<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias del proyecto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f9; }
        .contenedor { max-width: 1100px; margin: auto; background: white; padding: 25px; border-radius: 8px; }
        h1 { color: #263746; }
        .btn { display: inline-block; padding: 9px 14px; border-radius: 5px; text-decoration: none; color: white; margin: 4px; border: none; cursor: pointer; }
        .btn-primary { background: #1769aa; }
        .btn-secondary { background: #6c757d; }
        .btn-warning { background: #d99b18; }
        .alert { padding: 12px; margin-bottom: 15px; border-radius: 5px; background: #d4edda; color: #155724; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 11px; text-align: left; }
        th { background: #1769aa; color: white; }
        tr:nth-child(even) { background: #f2f2f2; }
        .severidad { font-weight: bold; }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Incidencias del proyecto</h1>
    <h3>{{ $proyecto->nombre }}</h3>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <a href="{{ route('proyectos.incidencias.create', $proyecto) }}" class="btn btn-primary">
        Registrar incidencia
    </a>

    <a href="{{ route('proyectos.show', $proyecto) }}" class="btn btn-secondary">
        Volver al proyecto
    </a>

    @if($incidencias->isEmpty())
        <p>No hay incidencias registradas para este proyecto.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Severidad</th>
                    <th>Estado</th>
                    <th>Fecha de registro</th>
                    <th>Responsable</th>
                    <th>Fecha de resolución</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incidencias as $incidencia)
                    <tr>
                        <td>{{ $incidencia->titulo }}</td>
                        <td class="severidad">{{ $incidencia->nivel_severidad }}</td>
                        <td>{{ $incidencia->estado }}</td>
                        <td>{{ $incidencia->fecha_registro->format('d/m/Y') }}</td>
                        <td>{{ $incidencia->responsable->name ?? 'Sin asignar' }}</td>
                        <td>
                            {{ $incidencia->fecha_resolucion
                                ? $incidencia->fecha_resolucion->format('d/m/Y')
                                : 'Pendiente' }}
                        </td>
                        <td>
                            <a href="{{ route('proyectos.incidencias.edit', [$proyecto, $incidencia]) }}"
                               class="btn btn-warning">
                                Editar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</body>
</html>
