<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Estados y Aprobaciones</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
        .success { background: #d4edda; color: #155724; padding: 10px; margin-top: 10px; }
        .btn { padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer; color: white; margin-right: 5px; }
        .btn-aprobar { background: #28a745; }
        .btn-rechazar { background: #dc3545; }
        .btn-cambiar { background: #007bff; }
    </style>
</head>
<body>
    <h1>Gestión de Proyectos (HU-12 y HU-15)</h1>
    <a href="{{ route('dashboard') }}">Volver al Dashboard</a>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Proyecto</th>
                <th>Estado Actual</th>
                <th>HU-12: Aprobación</th>
                <th>HU-15: Cambiar Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proyectos as $proyecto)
            <tr>
                <td>{{ $proyecto->nombre }}</td>
                <td><strong>{{ $proyecto->estado->nombre ?? 'Sin estado' }}</strong></td>
                
                <!-- Acciones HU-12 -->
                <td>
                    <form action="{{ route('proyectos.aprobar', $proyecto->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-aprobar">Aprobar</button>
                    </form>
                    <form action="{{ route('proyectos.rechazar', $proyecto->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-rechazar">Rechazar</button>
                    </form>
                </td>

                <!-- Acciones HU-15 -->
                <td>
                    <form action="{{ route('proyectos.cambiarEstado', $proyecto->id) }}" method="POST" style="display:flex; gap: 5px;">
                        @csrf
                        <select name="estado_proyecto_id" required>
                            @foreach(\App\Models\EstadoProyecto::all() as $estado)
                                <option value="{{ $estado->id }}" {{ $proyecto->estado_proyecto_id == $estado->id ? 'selected' : '' }}>
                                    {{ $estado->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-cambiar">Actualizar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>