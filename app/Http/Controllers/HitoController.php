<?php

namespace App\Http\Controllers;

use App\Models\Hito;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class HitoController extends Controller
{
    private function verificarResponsable(
        Request $request,
        Proyecto $proyecto
    ): void {
        $usuario = $request->user();

        abort_unless(
            $usuario &&
            $usuario->activo &&
            (int) $proyecto->creado_por_id === (int) $usuario->id,
            403,
            'No tiene permisos para gestionar el seguimiento de este proyecto.'
        );
    }

    public function index(
        Request $request,
        Proyecto $proyecto
    ): View {
        $this->verificarResponsable($request, $proyecto);

        $hitos = $proyecto->hitos()
            ->with('responsable')
            ->orderBy('fecha_planificada')
            ->get();

        return view(
            'hitos.index',
            compact('proyecto', 'hitos')
        );
    }

    public function create(
        Request $request,
        Proyecto $proyecto
    ): View {
        $this->verificarResponsable($request, $proyecto);

        return view('hitos.create', compact('proyecto'));
    }

    public function store(
        Request $request,
        Proyecto $proyecto
    ): RedirectResponse {
        $this->verificarResponsable($request, $proyecto);

        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:150',
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'fecha_planificada' => [
                'required',
                'date',
            ],
        ], [
            'nombre.required' => 'El nombre del hito es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 150 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 5000 caracteres.',
            'fecha_planificada.required' => 'La fecha planificada es obligatoria.',
            'fecha_planificada.date' => 'Debe ingresar una fecha válida.',
        ]);

        Hito::create([
            'proyecto_id' => $proyecto->id,
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'] ?? null,
            'fecha_planificada' => $datos['fecha_planificada'],
            'fecha_cumplimiento' => null,
            'estado' => 'Pendiente',
            'responsable_id' => $proyecto->creado_por_id,
        ]);

        return redirect()
            ->route('proyectos.hitos.index', $proyecto)
            ->with('success', 'El hito se registró correctamente.');
    }

    public function edit(
        Request $request,
        Proyecto $proyecto,
        Hito $hito
    ): View {
        $this->verificarResponsable($request, $proyecto);

        abort_unless(
            (int) $hito->proyecto_id === (int) $proyecto->id,
            404
        );

        return view(
            'hitos.edit',
            compact('proyecto', 'hito')
        );
    }

    public function update(
        Request $request,
        Proyecto $proyecto,
        Hito $hito
    ): RedirectResponse {
        $this->verificarResponsable($request, $proyecto);

        abort_unless(
            (int) $hito->proyecto_id === (int) $proyecto->id,
            404
        );

        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:150',
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'fecha_planificada' => [
                'required',
                'date',
            ],
            'fecha_cumplimiento' => [
                'nullable',
                'date',
            ],
            'estado' => [
                'required',
                Rule::in([
                    'Pendiente',
                    'En progreso',
                    'Completado',
                    'Atrasado',
                ]),
            ],
        ], [
            'nombre.required' => 'El nombre del hito es obligatorio.',
            'fecha_planificada.required' => 'La fecha planificada es obligatoria.',
            'fecha_planificada.date' => 'La fecha planificada no es válida.',
            'fecha_cumplimiento.date' => 'La fecha de cumplimiento no es válida.',
            'estado.required' => 'Debe seleccionar un estado.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ]);

        if ($datos['estado'] === 'Completado' && empty($datos['fecha_cumplimiento'])) {
            $datos['fecha_cumplimiento'] = now()->toDateString();
        }

        if ($datos['estado'] !== 'Completado') {
            $datos['fecha_cumplimiento'] = null;
        }

        $hito->update($datos);

        return redirect()
            ->route('proyectos.hitos.index', $proyecto)
            ->with('success', 'El hito se actualizó correctamente.');
    }
}

