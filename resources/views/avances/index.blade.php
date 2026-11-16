<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avances del proyecto</title>
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
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Seguimiento de avances</h1>
    <h3>{{ $proyecto->nombre }}</h3>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <a href="{{ route('proyectos.avances.create', $proyecto) }}" class="btn btn-primary">
        Registrar avance
    </a>

    <a href="{{ route('proyectos.show', $proyecto) }}" class="btn btn-secondary">
        Volver al proyecto
    </a>

    @if($avances->isEmpty())
        <p>No hay avances registrados para este proyecto.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Porcentaje de avance</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Registrado por</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($avances as $avance)
                    <tr>
                        <td>{{ number_format((float) $avance->porcentaje_avance, 2) }}%</td>
                        <td>{{ $avance->descripcion }}</td>
                        <td>{{ $avance->fecha->format('d/m/Y') }}</td>
                        <td>{{ $avance->registradoPor->name ?? 'No disponible' }}</td>
                        <td>
                            <a href="{{ route('proyectos.avances.edit', [$proyecto, $avance]) }}"
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
