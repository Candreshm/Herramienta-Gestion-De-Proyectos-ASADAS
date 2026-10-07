<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Completar información - {{ $proyecto->nombre }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }

        .contenedor {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 10px;
        }

        .descripcion {
            color: #555;
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 6px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .fila {
            display: flex;
            gap: 20px;
        }

        .campo {
            flex: 1;
        }

        .errores {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .botones {
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-guardar {
            background-color: #28a745;
            color: white;
        }

        .btn-cancelar {
            background-color: #6c757d;
            color: white;
            margin-left: 10px;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Completar información de la iniciativa</h1>

    <p class="descripcion">
        Proyecto:
        <strong>{{ $proyecto->codigo }} - {{ $proyecto->nombre }}</strong>
    </p>

    @if ($errors->any())
        <div class="errores">
            <strong>Se encontraron los siguientes errores:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('proyectos.hu05.update', $proyecto) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <label for="justificacion">
            Justificación
        </label>

        <textarea
            id="justificacion"
            name="justificacion"
            required
        >{{ old('justificacion', $proyecto->justificacion) }}</textarea>


        <label for="costo_estimado">
            Costo estimado
        </label>

        <input
            type="number"
            id="costo_estimado"
            name="costo_estimado"
            value="{{ old('costo_estimado', $proyecto->costo_estimado) }}"
            min="0"
            step="0.01"
            required
        >


        <label for="impacto_esperado">
            Impacto esperado
        </label>

        <textarea
            id="impacto_esperado"
            name="impacto_esperado"
            required
        >{{ old('impacto_esperado', $proyecto->impacto_esperado) }}</textarea>


        <div class="fila">

            <div class="campo">
                <label for="nivel_riesgo">
                    Nivel de riesgo
                </label>

                <select
                    id="nivel_riesgo"
                    name="nivel_riesgo"
                    required
                >
                    <option value="">Seleccione...</option>

                    <option
                        value="Bajo"
                        {{ old('nivel_riesgo', $proyecto->nivel_riesgo) === 'Bajo' ? 'selected' : '' }}
                    >
                        Bajo
                    </option>

                    <option
                        value="Medio"
                        {{ old('nivel_riesgo', $proyecto->nivel_riesgo) === 'Medio' ? 'selected' : '' }}
                    >
                        Medio
                    </option>

                    <option
                        value="Alto"
                        {{ old('nivel_riesgo', $proyecto->nivel_riesgo) === 'Alto' ? 'selected' : '' }}
                    >
                        Alto
                    </option>
                </select>
            </div>


            <div class="campo">
                <label for="criticidad">
                    Criticidad
                </label>

                <select
                    id="criticidad"
                    name="criticidad"
                    required
                >
                    <option value="">Seleccione...</option>

                    <option
                        value="Baja"
                        {{ old('criticidad', $proyecto->criticidad) === 'Baja' ? 'selected' : '' }}
                    >
                        Baja
                    </option>

                    <option
                        value="Media"
                        {{ old('criticidad', $proyecto->criticidad) === 'Media' ? 'selected' : '' }}
                    >
                        Media
                    </option>

                    <option
                        value="Alta"
                        {{ old('criticidad', $proyecto->criticidad) === 'Alta' ? 'selected' : '' }}
                    >
                        Alta
                    </option>
                </select>
            </div>

        </div>


        <label for="prioridad">
            Prioridad
        </label>

        <select
            id="prioridad"
            name="prioridad"
            required
        >
            <option value="">Seleccione...</option>

            <option
                value="Baja"
                {{ old('prioridad', $proyecto->prioridad) === 'Baja' ? 'selected' : '' }}
            >
                Baja
            </option>

            <option
                value="Media"
                {{ old('prioridad', $proyecto->prioridad) === 'Media' ? 'selected' : '' }}
            >
                Media
            </option>

            <option
                value="Alta"
                {{ old('prioridad', $proyecto->prioridad) === 'Alta' ? 'selected' : '' }}
            >
                Alta
            </option>
            </select>

            <label for="evidencia">
            Evidencia inicial
            </label>

            <input
            type="file"
            id="evidencia"
            name="evidencia"
            >

            <p style="color:#666; font-size:13px;">
            Puede adjuntar un archivo de evidencia de hasta 10 MB.
    </p>


        <div class="botones">

            <button
                type="submit"
                class="btn btn-guardar"
            >
                Guardar información
            </button>

            <a
                href="{{ route('proyectos.show', $proyecto) }}"
                class="btn btn-cancelar"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

</body>
</html>
