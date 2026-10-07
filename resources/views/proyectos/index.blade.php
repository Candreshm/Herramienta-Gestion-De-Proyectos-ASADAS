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
