<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitos del proyecto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f9; }
        .contenedor { max-width: 1000px; margin: auto; background: white; padding: 25px; border-radius: 8px; }
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
        .estado { font-weight: bold; }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Hitos del proyecto</h1>

    <h3>{{ $proyecto->nombre }}</h3>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <a href="{{ route('proyectos.hitos.create', $proyecto) }}" class="btn btn-primary">
        Registrar nuevo hito
    </a>

    <a href="{{ route('proyectos.show', $proyecto) }}" class="btn btn-secondary">
        Volver al proyecto
    </a>

    @if($hitos->isEmpty())
        <p>No hay hitos registrados para este proyecto.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha planificada</th>
                    <th>Fecha de cumplimiento</th>
                    <th>Estado</th>
                    <th>Responsable</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hitos as $hito)
                    <tr>
                        <td>{{ $hito->nombre }}</td>
                        <td>{{ $hito->fecha_planificada->format('d/m/Y') }}</td>
                        <td>
                            {{ $hito->fecha_cumplimiento
                                ? $hito->fecha_cumplimiento->format('d/m/Y')
                                : 'Pendiente' }}
                        </td>
                        <td class="estado">{{ $hito->estado }}</td>
                        <td>{{ $hito->responsable->name ?? 'No asignado' }}</td>
                        <td>
                            <a href="{{ route('proyectos.hitos.edit', [$proyecto, $hito]) }}"
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
