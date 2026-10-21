<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración de viabilidad</title>
</head>
<body>
    <h1>Configuración del modelo de viabilidad</h1>
    @if (session('success')) <p style="color:green">{{ session('success') }}</p> @endif
    @if ($errors->any())
        <ul style="color:red">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    @endif
    @php
        $criterios = $modelo?->criterios ?? [];
        $valor = fn ($campo, $clave, $defecto = 0) => old($campo, data_get($criterios, "$clave.$campo", $defecto));
    @endphp
    <form method="POST" action="{{ route('viabilidad.update') }}">
        @csrf @method('PUT')
        <h2>Umbral</h2>
        <label>Umbral mínimo (0-100)
            <input type="number" name="umbral_minimo" min="0" max="100" step="0.01" value="{{ old('umbral_minimo', $modelo?->umbral_minimo ?? 60) }}" required>
        </label>
        <h2>Ponderaciones (deben sumar 100)</h2>
        @foreach ([['riesgo','Riesgo',25],['criticidad','Criticidad',25],['prioridad','Prioridad',25],['costo','Costo estimado',25]] as [$clave,$nombre,$defecto])
            <label>{{ $nombre }}
                <input type="number" name="peso_{{ $clave }}" min="0" max="100" step="0.01" value="{{ old('peso_'.$clave, data_get($criterios, "$clave.peso", $defecto)) }}" required>
            </label><br>
        @endforeach
        <h2>Puntuaciones</h2>
        @foreach ([['riesgo','Bajo'],['riesgo','Medio'],['riesgo','Alto'],['criticidad','Baja'],['criticidad','Media'],['criticidad','Alta'],['prioridad','Baja'],['prioridad','Media'],['prioridad','Alta']] as [$criterio,$nivel])
            <label>{{ ucfirst($criterio) }} - {{ $nivel }}
                <input type="number" name="{{ $criterio }}_{{ strtolower($nivel) }}" min="0" max="100" step="0.01" value="{{ old($criterio.'_'.strtolower($nivel), data_get($criterios, "$criterio.valores.$nivel", $nivel === 'Bajo' || $nivel === 'Baja' ? 100 : ($nivel === 'Medio' || $nivel === 'Media' ? 60 : 20))) }}" required>
            </label><br>
        @endforeach
        <label>Valor máximo de costo considerado
            <input type="number" name="maximo_costo" min="0.01" step="0.01" value="{{ old('maximo_costo', data_get($criterios, 'costo_estimado.maximo', 1000000)) }}" required>
        </label><br><br>
        <button type="submit">Guardar configuración</button>
    </form>
    <p><a href="{{ route('proyectos.index') }}">Volver a proyectos</a></p>
</body>
</html>
