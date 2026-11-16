<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar avance</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f9; }
        .contenedor { max-width: 700px; margin: auto; background: white; padding: 25px; border-radius: 8px; }
        h1 { color: #263746; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; margin-top: 6px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        textarea { min-height: 120px; }
        .btn { display: inline-block; padding: 10px 15px; border-radius: 5px; text-decoration: none; color: white; margin-top: 18px; border: none; cursor: pointer; }
        .btn-primary { background: #1769aa; }
        .btn-secondary { background: #6c757d; }
        .error { color: #b02a37; font-size: 14px; margin-top: 5px; }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Registrar avance del proyecto</h1>
    <h3>{{ $proyecto->nombre }}</h3>

    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proyectos.avances.store', $proyecto) }}" method="POST">
        @csrf

        <label for="porcentaje_avance">Porcentaje de avance (0 a 100)</label>
        <input type="number" id="porcentaje_avance" name="porcentaje_avance"
               min="0" max="100" step="0.01"
               value="{{ old('porcentaje_avance') }}" required>

        <label for="descripcion">Descripción del avance</label>
        <textarea id="descripcion" name="descripcion" minlength="10"
                  maxlength="5000" required>{{ old('descripcion') }}</textarea>

        <label for="fecha">Fecha del avance</label>
        <input type="date" id="fecha" name="fecha"
               value="{{ old('fecha', now()->format('Y-m-d')) }}" required>

        <button type="submit" class="btn btn-primary">Guardar avance</button>

        <a href="{{ route('proyectos.avances.index', $proyecto) }}"
           class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
