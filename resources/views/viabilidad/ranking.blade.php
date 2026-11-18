@extends('layouts.app')

@section('title', 'Ranking de proyectos')

@section('content')

<div class="page-header">

    <div>
        <h2 class="page-title">
            Ranking y priorización de proyectos
        </h2>

        <p class="page-subtitle">
            Consulte la priorización de proyectos según su evaluación de viabilidad.
        </p>
    </div>

    <a
        href="{{ route('dashboard') }}"
        class="btn btn-secondary"
    >
        Volver al panel
    </a>

</div>

<div class="card">

    <form
        method="GET"
        action="{{ route('viabilidad.ranking') }}"
        class="filters-grid"
    >

        <div>
            <label
                for="buscar"
                class="form-label"
            >
                Buscar proyecto
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
                for="dictamen"
                class="form-label"
            >
                Dictamen
            </label>

            <select
                id="dictamen"
                name="dictamen"
            >
                <option value="">
                    Todos
                </option>

                <option
                    value="Viable"
                    {{ request('dictamen') === 'Viable' ? 'selected' : '' }}
                >
                    Viable
                </option>

                <option
                    value="No viable"
                    {{ request('dictamen') === 'No viable' ? 'selected' : '' }}
                >
                    No viable
                </option>

            </select>
        </div>

        <div></div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Aplicar
            </button>

            <a
                href="{{ route('viabilidad.ranking') }}"
                class="btn btn-secondary"
            >
                Limpiar
            </a>

        </div>

    </form>

    @if($proyectos->count() > 0)

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>Prioridad</th>
                        <th>Código</th>
                        <th>Proyecto</th>
                        <th>Puntaje</th>
                        <th>Dictamen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($proyectos as $proyecto)

                        <tr>

                            <td>
                                <span class="ranking-position">
                                    {{ $proyectos->firstItem() + $loop->index }}
                                </span>
                            </td>

                            <td>
                                {{ $proyecto->codigo }}
                            </td>

                            <td>
                                {{ $proyecto->nombre }}
                            </td>

                            <td>

                                @if($proyecto->evaluacion?->puntaje_total !== null)

                                    <span class="score-value">
                                        {{ number_format(
                                            $proyecto->evaluacion->puntaje_total,
                                            2
                                        ) }}
                                    </span>

                                @else

                                    <span class="badge badge-neutral">
                                        Sin calcular
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($proyecto->evaluacion?->dictamen === 'Viable')

                                    <span class="badge badge-success">
                                        Viable
                                    </span>

                                @elseif($proyecto->evaluacion?->dictamen === 'No viable')

                                    <span class="badge badge-danger">
                                        No viable
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        Pendiente
                                    </span>

                                @endif

                            </td>

                            <td>

                                <div class="table-actions">

                                    <a
                                        href="{{ route('proyectos.show', $proyecto) }}"
                                        class="btn btn-secondary"
                                    >
                                        Ver proyecto
                                    </a>

                                    <form
                                        action="{{ route('viabilidad.calcular', $proyecto->id) }}"
                                        method="POST"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                        >
                                            Calcular dictamen
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        @if($proyectos->hasPages())

            <div class="section-spacing">
                {{ $proyectos->links() }}
            </div>

        @endif

    @else

        <div class="empty-state">
            No hay proyectos que coincidan con los criterios seleccionados.
        </div>

    @endif

</div>

@endsection