<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciativas de Proyecto</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
            color: white;
        }

        .btn-primary {
            background-color: #0066cc;
        }

        .btn-ver {
            background-color: #009900;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }

        .estado {
            font-weight: bold;
        }
        .filtros {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    align-items: end;
    margin: 20px 0;
    padding: 15px;
    background-color: #f4f4f4;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.filtros div {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.filtros label {
    font-weight: bold;
}

.filtros select {
    min-width: 160px;
    padding: 7px;
    border: 1px solid #aaa;
    border-radius: 3px;
    background-color: white;
}

.btn-limpiar {
    background-color: #666;
}
    </style>
</head>

<body>

    <h1>Iniciativas de Proyecto</h1>

    <p>
        <a href="{{ route('dashboard') }}">
            &larr; Volver al Panel
        </a>
        |
        <a
            href="{{ route('proyectos.create') }}"
            class="btn btn-primary"
        >
            + Nueva Iniciativa
        </a>
    </p>

     }}" class="filtros">
    <div>
        <label for="estado">Estado:</label>
        <select name="estado" id="estado">
            <option value="">Todos</option>

            @foreach($estados as $estado)
                <option
                    value="{{ $estado->id }}"
                    {{ request('estado') == $estado->id ? 'selected' : '' }}
                >
                    {{ $estado->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="criticidad">Criticidad:</label>
        <select name="criticidad" id="criticidad">
            <option value="">Todas</option>
            <option value="Baja" {{ request('criticidad') === 'Baja' ? 'selected' : '' }}>
                Baja
            </option>
            <option value="Media" {{ request('criticidad') === 'Media' ? 'selected' : '' }}>
                Media
            </option>
            <option value="Alta" {{ request('criticidad') === 'Alta' ? 'selected' : '' }}>
                Alta
            </option>
        </select>
    </div>

    <div>
        <label for="prioridad">Prioridad:</label>
        <select name="prioridad" id="prioridad">
            <option value="">Todas</option>
            <option value="Baja" {{ request('prioridad') === 'Baja' ? 'selected' : '' }}>
                Baja
            </option>
            <option value="Media" {{ request('prioridad') === 'Media' ? 'selected' : '' }}>
                Media
            </option>
            <option value="Alta" {{ request('prioridad') === 'Alta' ? 'selected' : '' }}>
                Alta
            </option>
        </select>
    </div>

    <div>
        <button type="submit" class="btn btn-primary">
            Filtrar
        </button>

         }}" class="btn btn-limpiar">
            Limpiar filtros
        </a>
    </div>
</form>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Registrado por</th>
                <th>Fecha de registro</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            @forelse($proyectos as $proyecto)

                <tr>
                    <td>{{ $proyecto->codigo }}</td>

                    <td>{{ $proyecto->nombre }}</td>

                    <td>
                        <span class="estado">
                            {{ $proyecto->estado->nombre }}
                        </span>
                    </td>

                    <td>
                        {{ $proyecto->creador->name }}
                    </td>

                    <td>
                        {{ $proyecto->created_at?->format('d/m/Y H:i') }}
                    </td>

                    <td>
                        <a
                            href="{{ route('proyectos.show', $proyecto) }}"
                            class="btn btn-ver"
                        >
                            Ver detalles
                        </a>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="6" style="text-align:center;">
                        No hay iniciativas registradas.
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>

</body>
</html>
