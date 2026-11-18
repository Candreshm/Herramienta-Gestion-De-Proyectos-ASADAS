@extends('layouts.app')

@section('title', 'Expediente documental')

@section('content')

<div class="page-header">

    <div>
        <h2 class="page-title">
            Expediente documental
        </h2>

        <p class="page-subtitle">
            {{ $proyecto->codigo }}
            —
            {{ $proyecto->nombre }}
        </p>
    </div>

    <a
        href="{{ route('proyectos.show', $proyecto) }}"
        class="btn btn-secondary"
    >
        Volver al proyecto
    </a>

</div>

<div class="card">

    <h3 class="section-title">
        Agregar documento
    </h3>

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ route(
            'proyectos.documentos.store',
            $proyecto
        ) }}"
    >
        @csrf

        <div class="form-grid">

            <div class="form-group">

                <label
                    for="tipo_documento_id"
                    class="form-label"
                >
                    Tipo de documento
                </label>

                <select
                    id="tipo_documento_id"
                    name="tipo_documento_id"
                    required
                >
                    <option value="">
                        Seleccione
                    </option>

                    @foreach($tipos as $tipo)

                        <option
                            value="{{ $tipo->id }}"
                            @selected(
                                old(
                                    'tipo_documento_id'
                                ) == $tipo->id
                            )
                        >
                            {{ $tipo->nombre }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

                <label
                    for="fecha_documento"
                    class="form-label"
                >
                    Fecha del documento
                </label>

                <input
                    type="date"
                    id="fecha_documento"
                    name="fecha_documento"
                    value="{{ old('fecha_documento') }}"
                >

            </div>

            <div class="form-group">

                <label
                    for="archivo"
                    class="form-label"
                >
                    Archivo
                </label>

                <input
                    type="file"
                    id="archivo"
                    name="archivo"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                    required
                >

                <p class="form-help">
                    Máximo 10 MB.
                </p>

            </div>

        </div>

        <div class="form-group">

            <label
                for="descripcion"
                class="form-label"
            >
                Descripción
            </label>

            <textarea
                id="descripcion"
                name="descripcion"
                maxlength="5000"
            >{{ old('descripcion') }}</textarea>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-success"
            >
                Agregar al expediente
            </button>

        </div>

    </form>

</div>

<div class="card section-spacing">

    <h3 class="section-title">
        Documentos del expediente
    </h3>

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Documento</th>
                    <th>Fecha</th>
                    <th>Subido por</th>
                    <th>Tamaño</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                @forelse($documentos as $documento)

                    <tr>

                        <td>
                            {{ $documento->tipo?->nombre }}
                        </td>

                        <td>
                            <strong>
                                {{ $documento->nombre_original }}
                            </strong>

                            @if($documento->descripcion)
                                <div class="form-help">
                                    {{ $documento->descripcion }}
                                </div>
                            @endif
                        </td>

                        <td>
                            {{ $documento
                                ->fecha_documento
                                ?->format('d/m/Y')
                                ?? 'Sin fecha'
                            }}
                        </td>

                        <td>
                            {{ $documento
                                ->subidoPor
                                ?->name
                                ?? 'Sin usuario'
                            }}
                        </td>

                        <td>
                            {{ number_format(
                                $documento->tamano_bytes
                                / 1024,
                                2
                            ) }} KB
                        </td>

                        <td>

                            <div class="table-actions">

                                <a
                                    href="{{ route(
                                        'proyectos.documentos.download',
                                        [
                                            $proyecto,
                                            $documento
                                        ]
                                    ) }}"
                                    class="btn btn-primary"
                                >
                                    Descargar
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'proyectos.documentos.destroy',
                                        [
                                            $proyecto,
                                            $documento
                                        ]
                                    ) }}"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                        onclick="return confirm(
                                            '¿Retirar este documento del expediente?'
                                        )"
                                    >
                                        Retirar
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                No hay documentos registrados.
                            </div>
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="pagination-wrapper">
        {{ $documentos->links() }}
    </div>

</div>

@endsection