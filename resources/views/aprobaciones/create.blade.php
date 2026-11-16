<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar acuerdo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            max-width: 800px;
        }

        .formulario {
            border: 1px solid #ccc;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .campo {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input, select, textarea {
            width: 100%;
            padding: 9px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            background: #245b91;
            color: white;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-secundario {
            background: #555;
        }

        .error {
            color: #b00020;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <h1>Registrar acuerdo o decisión</h1>

    <h3>Proyecto: {{ $proyecto->nombre }}</h3>
    <p>Código: {{ $proyecto->codigo }}</p>

    <div class="formulario">

        <form method="POST"
              action="{{ route('proyectos.aprobaciones.store', $proyecto) }}">

            @csrf

            <div class="campo">
                <label for="tipo_decision">Tipo de decisión:</label>

                <select name="tipo_decision" id="tipo_decision" required>
                    <option value="">Seleccione una decisión</option>

                    <option value="APROBADO"
                        {{ old('tipo_decision') == 'APROBADO' ? 'selected' : '' }}>
                        Aprobado
                    </option>

                    <option value="RECHAZADO"
                        {{ old('tipo_decision') == 'RECHAZADO' ? 'selected' : '' }}>
                        Rechazado
                    </option>

                    <option value="DEVUELTO"
                        {{ old('tipo_decision') == 'DEVUELTO' ? 'selected' : '' }}>
                        Devuelto
                    </option>
                </select>

                @error('tipo_decision')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="campo">
                <label for="fecha_acuerdo">Fecha del acuerdo:</label>

                <input
                    type="date"
                    name="fecha_acuerdo"
                    id="fecha_acuerdo"
                    value="{{ old('fecha_acuerdo', now()->format('Y-m-d')) }}"
                    required
                >

                @error('fecha_acuerdo')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="campo">
                <label for="responsable_id">Responsable del acuerdo:</label>

                <select name="responsable_id" id="responsable_id" required>
                    <option value="">Seleccione un responsable</option>

                    @foreach($usuarios as $usuario)
                        <option
                            value="{{ $usuario->id }}"
                            {{ old('responsable_id') == $usuario->id ? 'selected' : '' }}
                        >
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>

                @error('responsable_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="campo">
                <label for="justificacion">Justificación del acuerdo:</label>

                <textarea
                    name="justificacion"
                    id="justificacion"
                    required
                    minlength="10"
                    maxlength="5000"
                >{{ old('justificacion') }}</textarea>

                @error('justificacion')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn">
                Guardar acuerdo
            </button>

            <a href="{{ route('proyectos.aprobaciones.index', $proyecto) }}"
               class="btn btn-secundario">
                Cancelar
            </a>

        </form>

    </div>

</body>
</html>
