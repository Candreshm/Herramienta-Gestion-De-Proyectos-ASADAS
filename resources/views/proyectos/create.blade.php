<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Iniciativa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            max-width: 700px;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button,
        .btn {
            padding: 8px 15px;
            margin-top: 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: #0066cc;
            color: white;
        }

        .btn-secondary {
            background-color: #ccc;
            color: black;
        }

        .errores {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 15px;
        }

        .errores ul {
            margin: 5px 0;
            padding-left: 20px;
        }

        .obligatorio {
            color: red;
        }

        .ayuda {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <h1>Registrar Nueva Iniciativa</h1>

    <p>
        <a href="{{ route('proyectos.index') }}">
            &larr; Volver al listado
        </a>
    </p>

    @if($errors->any())
        <div class="errores">
            <strong>Se encontraron los siguientes errores:</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proyectos.store') }}" method="POST">
        @csrf

        <label for="codigo">
            Código <span class="obligatorio">*</span>
        </label>

        <input
            type="text"
            id="codigo"
            name="codigo"
            value="{{ old('codigo') }}"
            maxlength="50"
            required
        >

        <p class="ayuda">
            El código debe identificar de forma única la iniciativa.
        </p>

        <label for="nombre">
            Nombre de la iniciativa <span class="obligatorio">*</span>
        </label>

        <input
            type="text"
            id="nombre"
            name="nombre"
            value="{{ old('nombre') }}"
            maxlength="255"
            required
        >

        <label for="descripcion">
            Descripción <span class="obligatorio">*</span>
        </label>

        <textarea
            id="descripcion"
            name="descripcion"
            required
        >{{ old('descripcion') }}</textarea>

        <label for="objetivo">
            Objetivo <span class="obligatorio">*</span>
        </label>

        <textarea
            id="objetivo"
            name="objetivo"
            required
        >{{ old('objetivo') }}</textarea>

        <div>
            <button type="submit" class="btn-primary">
                Registrar Iniciativa
            </button>

            <a
                href="{{ route('proyectos.index') }}"
                class="btn btn-secondary"
            >
                Cancelar
            </a>
        </div>
    </form>

</body>
</html>
