<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluar proyecto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 850px;
            margin: 30px auto;
            padding: 20px;
            color: #263238;
            background: #f4f7f6;
        }

        .contenedor {
            background: white;
            padding: 28px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #00000012;
        }

        h1, h2 {
            color: #245b45;
        }

        .criterio {
            border: 1px solid #d8e3dd;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        select, input[type="date"], textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #b8c8bf;
            border-radius: 5px;
            margin-bottom: 8px;
        }

        button, .enlace {
            display: inline-block;
            background: #245b45;
            color: white;
            padding: 11px 16px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .errores {
            background: #fde8e7;
            color: #9b2525;
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 18px;
        }

        .ayuda {
            color: #52635a;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Evaluación del proyecto</h1>

    <p>
        <strong>Proyecto:</strong>
        {{ $proyecto->codigo }} - {{ $proyecto->nombre }}
    </p>

    <p class="ayuda">
        Asigne una puntuación del 1 al 5 a cada criterio.
        Todos los criterios son obligatorios.
    </p>

    @if ($errors->any())
        <div class="errores">
            <strong>Revise los siguientes errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('proyectos.evaluacion.store', $proyecto) }}"
        method="POST"
    >
        @csrf

        <label for="fecha_evaluacion">Fecha de evaluación</label>
        <input
            type="date"
            id="fecha_evaluacion"
            name="fecha_evaluacion"
            value="{{ old('fecha_evaluacion', now()->toDateString()) }}"
            required
        >

        <h2>Criterios de evaluación</h2>

        @php
            $criterios = [
                'tecnico' => 'Técnico',
                'financiero' => 'Financiero',
                'operativo' => 'Operativo',
                'normativo' => 'Normativo',
            ];
        @endphp

        @foreach ($criterios as $clave => $nombre)
            <div class="criterio">
                <label for="criterio_{{ $clave }}">
                    {{ $nombre }}
                </label>

                <select
                    id="criterio_{{ $clave }}"
                    name="criterios[{{ $clave }}]"
                    required
                >
                    <option value="">Seleccione una puntuación</option>

                    @for ($puntuacion = 1; $puntuacion <= 5; $puntuacion++)
                        <option
                            value="{{ $puntuacion }}"
                            @selected(
                                old('criterios.' . $clave) == $puntuacion
                            )
                        >
                            {{ $puntuacion }} -
                            @switch($puntuacion)
                                @case(1)
                                    Muy bajo
                                    @break
                                @case(2)
                                    Bajo
                                    @break
                                @case(3)
                                    Medio
                                    @break
                                @case(4)
                                    Alto
                                    @break
                                @case(5)
                                    Muy alto
                                    @break
                            @endswitch
                        </option>
                    @endfor
                </select>
            </div>
        @endforeach

        <label for="observaciones">Observaciones generales (opcional)</label>
        <textarea
            id="observaciones"
            name="observaciones"
            rows="4"
        >{{ old('observaciones') }}</textarea>

        <button type="submit">Guardar evaluación</button>

        <a
            class="enlace"
            href="{{ route('proyectos.show', $proyecto) }}"
        >
            Volver al proyecto
        </a>
    </form>
</div>
</body>
</html>
