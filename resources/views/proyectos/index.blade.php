@extends('layouts.app')

@section('title', 'Iniciativas de Proyecto')

@section('content')

<div class="project-list-header">

    <div>
        <h2 class="page-title project-list-title">
            Iniciativas de Proyecto
        </h2>

        <p class="project-list-subtitle">
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
        class="project-filters"
    >

        <div>

            <label
                for="buscar"
                class="form-label"
            >
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

            <label
                for="estado"
                class="form-label"
            >
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

            <label
                for="criticidad"
                class="form-label"
            >
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

            <label
                for="prioridad"
                class="form-label"
            >
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

        <div class="project-filter-actions">

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

    <div class="table-wrapper">

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

                            <div class="table-actions">

                                <a
                                    href="{{ route('proyectos.show', $proyecto) }}"
                                    class="btn btn-primary"
                                >
                                    Ver
                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="8"
                            class="empty-state"
                        >
                            No se encontraron iniciativas con los criterios seleccionados.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($proyectos->hasPages())

        <div class="pagination-wrapper">
            {{ $proyectos->links() }}
        </div>

    @endif

</div>

@endsection