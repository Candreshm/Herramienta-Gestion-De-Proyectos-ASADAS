@extends('layouts.app')

@section('title', 'Iniciativas de Proyecto')

@section('content')

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:20px;
        flex-wrap:wrap;
        margin-bottom:20px;
    ">
        <div>
            <h2 class="page-title" style="margin-bottom:5px;">
                Iniciativas de Proyecto
            </h2>

            <p style="margin:0; color:#64748b;">
                Consulta, búsqueda y filtrado de iniciativas registradas.
            </p>
        </div>

        <div class="actions">
            <a
                href="{{ route('dashboard') }}"
                class="btn btn-secondary"
            >
                Volver al panel
            </a>

            <a
                href="{{ route('proyectos.create') }}"
                class="btn btn-primary"
            >
                + Nueva iniciativa
            </a>
        </div>
    </div>

    <div class="card">

        <form
            method="GET"
            action="{{ route('proyectos.index') }}"
            style="
                display:grid;
                grid-template-columns:
                    minmax(220px, 2fr)
                    repeat(3, minmax(150px, 1fr))
                    auto;
                gap:15px;
                align-items:end;
                margin-bottom:25px;
            "
        >

            <div>
                <label for="buscar">
                    Buscar
                </label>

                <input
                    type="search"
                    id="buscar"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Código o nombre"
                >
            </div>

            <div>
                <label for="estado">
                    Estado
                </label>

                <select
                    name="estado"
                    id="estado"
                >
                    <option value="">
                        Todos
                    </option>

                    @foreach($estados as $estado)
                        <option
                            value="{{ $estado->id }}"
                            {{ (string) request('estado') === (string) $estado->id ? 'selected' : '' }}
                        >
                            {{ $estado->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="criticidad">
                    Criticidad
                </label>

                <select
                    name="criticidad"
                    id="criticidad"
                >
                    <option value="">
                        Todas
                    </option>

                    <option
                        value="Baja"
                        {{ request('criticidad') === 'Baja' ? 'selected' : '' }}
                    >
                        Baja
                    </option>

                    <option
                        value="Media"
                        {{ request('criticidad') === 'Media' ? 'selected' : '' }}
                    >
                        Media
                    </option>

                    <option
                        value="Alta"
                        {{ request('criticidad') === 'Alta' ? 'selected' : '' }}
                    >
                        Alta
                    </option>
                </select>
            </div>

            <div>
                <label for="prioridad">
                    Prioridad
                </label>

                <select
                    name="prioridad"
                    id="prioridad"
                >
                    <option value="">
                        Todas
                    </option>

                    <option
                        value="Baja"
                        {{ request('prioridad') === 'Baja' ? 'selected' : '' }}
                    >
                        Baja
                    </option>

                    <option
                        value="Media"
                        {{ request('prioridad') === 'Media' ? 'selected' : '' }}
                    >
                        Media
                    </option>

                    <option
                        value="Alta"
                        {{ request('prioridad') === 'Alta' ? 'selected' : '' }}
                    >
                        Alta
                    </option>
                </select>
            </div>

            <div
                style="
                    display:flex;
                    gap:8px;
                    flex-wrap:wrap;
                "
            >
                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Aplicar
                </button>

                <a
                    href="{{ route('proyectos.index') }}"
                    class="btn btn-secondary"
                >
                    Limpiar
                </a>
            </div>

        </form>

        <div
            style="
                overflow-x:auto;
                border:1px solid #e5e7eb;
                border-radius:8px;
            "
        >
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Criticidad</th>
                        <th>Prioridad</th>
                        <th>Registrado por</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($proyectos as $proyecto)

                        <tr>
                            <td>
                                {{ $proyecto->codigo }}
                            </td>

                            <td>
                                {{ $proyecto->nombre }}
                            </td>

                            <td>
                                <strong>
                                    {{ $proyecto->estado?->nombre ?? 'Sin estado' }}
                                </strong>
                            </td>

                            <td>
                                {{ $proyecto->criticidad ?? 'No definida' }}
                            </td>

                            <td>
                                {{ $proyecto->prioridad ?? 'No definida' }}
                            </td>

                            <td>
                                {{ $proyecto->creador?->name ?? 'Sin usuario' }}
                            </td>

                            <td>
                                {{ $proyecto->created_at?->format('d/m/Y') }}
                            </td>

                            <td>
                                <a
                                    href="{{ route('proyectos.show', $proyecto) }}"
                                    class="btn btn-primary"
                                >
                                    Ver
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="8"
                                style="
                                    text-align:center;
                                    padding:30px;
                                    color:#64748b;
                                "
                            >
                                No se encontraron iniciativas con los criterios seleccionados.
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">
            {{ $proyectos->links() }}
        </div>

    </div>

@endsection