<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ranking de Proyectos</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
        .viable { color: green; font-weight: bold; }
        .no-viable { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Ranking y Priorización de Proyectos (HU-10)</h1>
    <a href="{{ route('dashboard') }}">Volver al Dashboard</a>

    @if(isset($mensaje))
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-top: 20px;">
            {{ $mensaje }}
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Prioridad</th>
                    <th>Proyecto</th>
                    <th>Puntaje</th>
                    <th>Dictamen (HU-09)</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proyectos as $index => $proyecto)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $proyecto->nombre ?? 'Proyecto ' . $proyecto->id }}</td>
                    <td>{{ $proyecto->evaluacion->puntaje_total ?? 'Sin calcular' }}</td>
                    <td>
                        @if($proyecto->evaluacion->dictamen == 'Viable')
                            <span class="viable">Viable</span>
                        @elseif($proyecto->evaluacion->dictamen == 'No viable')
                            <span class="no-viable">No viable</span>
                        @else
                            <span>Pendiente</span>
                        @endif
                    </td>
                    <td>
                        <!-- Botón para simular HU-09 -->
                        <form action="{{ route('viabilidad.calcular', $proyecto->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Calcular Dictamen</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
</body>
</html>