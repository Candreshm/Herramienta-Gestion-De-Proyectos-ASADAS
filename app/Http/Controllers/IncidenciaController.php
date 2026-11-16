<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IncidenciaController extends Controller
{
    private function verificarResponsable(Request $request, Proyecto $proyecto): void
    {
        $usuario = $request->user();

        abort_unless(
            $usuario &&
            $usuario->activo &&
            (int) $proyecto->creado_por_id === (int) $usuario->id,
            403,
            'No tiene permisos para gestionar las incidencias de este proyecto.'
        );
    }

    public function index(Request $request, Proyecto $proyecto): View
    {
        $this->verificarResponsable($request, $proyecto);

        $incidencias = $proyecto->incidencias()
            ->with(['registradoPor', 'responsable'])
            ->orderByDesc('fecha_registro')
            ->get();

        return view('incidencias.index', compact('proyecto', 'incidencias'));
    }

    public function create(Request $request, Proyecto $proyecto): View
    {
        $this->verificarResponsable($request, $proyecto);

        $usuarios = \App\Models\User::where('activo', true)
            ->orderBy('name')
            ->get();

        return view('incidencias.create', compact('proyecto', 'usuarios'));
    }

    public function store(Request $request, Proyecto $proyecto): RedirectResponse
    {
        $this->verificarResponsable($request, $proyecto);

        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string', 'min:10', 'max:5000'],
            'nivel_severidad' => ['required', Rule::in(['Baja', 'Media', 'Alta', 'Crítica'])],
            'fecha_registro' => ['required', 'date'],
            'responsable_id' => [
                'nullable',
                Rule::exists('users', 'id')->where('activo', true),
            ],
        ], [
            'titulo.required' => 'El título de la incidencia es obligatorio.',
            'titulo.max' => 'El título no puede superar los 150 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
            'nivel_severidad.required' => 'Debe seleccionar un nivel de severidad.',
            'nivel_severidad.in' => 'El nivel de severidad seleccionado no es válido.',
            'fecha_registro.required' => 'La fecha de registro es obligatoria.',
            'responsable_id.exists' => 'El responsable seleccionado no existe o está inactivo.',
        ]);

        Incidencia::create([
            'proyecto_id' => $proyecto->id,
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'],
            'nivel_severidad' => $datos['nivel_severidad'],
            'estado' => 'Abierta',
            'fecha_registro' => $datos['fecha_registro'],
            'fecha_resolucion' => null,
            'registrado_por_id' => $request->user()->id,
            'responsable_id' => $datos['responsable_id'] ?? null,
        ]);

        return redirect()->route('proyectos.incidencias.index', $proyecto)
            ->with('success', 'La incidencia se registró correctamente.');
    }

    public function edit(
        Request $request,
        Proyecto $proyecto,
        Incidencia $incidencia
    ): View {
        $this->verificarResponsable($request, $proyecto);

        abort_unless(
            (int) $incidencia->proyecto_id === (int) $proyecto->id,
            404
        );

        $usuarios = \App\Models\User::where('activo', true)
            ->orderBy('name')
            ->get();

        return view('incidencias.edit', compact('proyecto', 'incidencia', 'usuarios'));
    }

    public function update(
        Request $request,
        Proyecto $proyecto,
        Incidencia $incidencia
    ): RedirectResponse {
        $this->verificarResponsable($request, $proyecto);

        abort_unless(
            (int) $incidencia->proyecto_id === (int) $proyecto->id,
            404
        );

        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string', 'min:10', 'max:5000'],
            'nivel_severidad' => ['required', Rule::in(['Baja', 'Media', 'Alta', 'Crítica'])],
            'estado' => ['required', Rule::in(['Abierta', 'En seguimiento', 'Resuelta', 'Cerrada'])],
            'fecha_registro' => ['required', 'date'],
            'fecha_resolucion' => ['nullable', 'date', 'after_or_equal:fecha_registro'],
            'responsable_id' => [
                'nullable',
                Rule::exists('users', 'id')->where('activo', true),
            ],
        ], [
            'titulo.required' => 'El título de la incidencia es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
            'nivel_severidad.in' => 'El nivel de severidad seleccionado no es válido.',
            'estado.in' => 'El estado seleccionado no es válido.',
            'fecha_registro.required' => 'La fecha de registro es obligatoria.',
            'fecha_resolucion.after_or_equal' => 'La fecha de resolución no puede ser anterior a la fecha de registro.',
            'responsable_id.exists' => 'El responsable seleccionado no existe o está inactivo.',
        ]);

        if (in_array($datos['estado'], ['Resuelta', 'Cerrada'], true)) {
            $datos['fecha_resolucion'] = $datos['fecha_resolucion'] ?? now()->toDateString();
        } else {
            $datos['fecha_resolucion'] = null;
        }

        $incidencia->update([
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'],
            'nivel_severidad' => $datos['nivel_severidad'],
            'estado' => $datos['estado'],
            'fecha_registro' => $datos['fecha_registro'],
            'fecha_resolucion' => $datos['fecha_resolucion'],
            'responsable_id' => $datos['responsable_id'] ?? null,
        ]);

        return redirect()->route('proyectos.incidencias.index', $proyecto)
            ->with('success', 'La incidencia se actualizó correctamente.');
    }
}
