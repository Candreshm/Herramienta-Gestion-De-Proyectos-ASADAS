<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de evaluaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background: #f4f7f6;
            color: #263238;
        }

        .contenedor {
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1, h2 {
            color: #245b45;
        }

        .evaluacion {
            border: 1px solid #d8e3dd;
            padding: 18px;
            margin: 18px 0;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th, td {
            border: 1px solid #d8e3dd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #e9f1ec;
        }

        .boton {
            display: inline-block;
            background: #245b45;
            color: white;
            padding: 11px 16px;
            border-radius: 5px;
            text-decoration: none;
            margin: 5px 5px 5px 0;
        }

        .mensaje {
            background: #e7f4e9;
            padding: 12px;
            border-radius: 5px;
            color: #205c32;
        }

        .vacio {
            padding: 18px;
            background: #f2f4f3;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Historial de evaluaciones</h1>

    <p>
        <strong>Proyecto:</strong>
        {{ $proyecto->codigo }} - {{ $proyecto->nombre }}
    </p>

    @if (session('success'))
        <p class="mensaje">{{ session('success') }}</p>
    @endif

    <a
        class="boton"
        href="{{ route('proyectos.evaluacion.create', $proyecto) }}"
    >
        Registrar evaluación
    </a>

    <a
        class="boton"
        href="{{ route('proyectos.show', $proyecto) }}"
    >
        Volver al proyecto
    </a>

    @forelse ($evaluaciones as $evaluacion)
        <div class="evaluacion">
            <h2>
                Evaluación del
                {{ $evaluacion->fecha_evaluacion->format('d/m/Y') }}
            </h2>

            <p>
                <strong>Evaluador:</strong>
                {{ $evaluacion->evaluador->name ?? 'No disponible' }}
            </p>

            <table>
                <thead>
                    <tr>
                        <th>Criterio</th>
                        <th>Puntuación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluacion->criterios as $criterio)
                        <tr>
                            <td>{{ $criterio->criterio }}</td>
                            <td>{{ $criterio->puntuacion }} / 5</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($evaluacion->observaciones)
                <p>
                    <strong>Observaciones:</strong>
                    {{ $evaluacion->observaciones }}
                </p>
            @endif
        </div>
    @empty
        <div class="vacio">
            Este proyecto todavía no tiene evaluaciones registradas.
        </div>
    @endforelse
</div>
</body>
</html>
