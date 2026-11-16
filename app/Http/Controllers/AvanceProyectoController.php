<?php

namespace App\Http\Controllers;

use App\Models\AvanceProyecto;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AvanceProyectoController extends Controller
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

        $avances = $proyecto->avances()
            ->with('registradoPor')
            ->orderByDesc('fecha')
            ->get();

        return view(
            'avances.index',
            compact('proyecto', 'avances')
        );
    }

    public function create(
        Request $request,
        Proyecto $proyecto
    ): View {
        $this->verificarResponsable($request, $proyecto);

        return view('avances.create', compact('proyecto'));
    }

    public function store(
        Request $request,
        Proyecto $proyecto
    ): RedirectResponse {
        $this->verificarResponsable($request, $proyecto);

        $datos = $request->validate([
            'porcentaje_avance' => [
                'required',
                'numeric',
                'between:0,100',
            ],
            'descripcion' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],
            'fecha' => [
                'required',
                'date',
            ],
        ], [
            'porcentaje_avance.required' => 'El porcentaje de avance es obligatorio.',
            'porcentaje_avance.numeric' => 'El porcentaje debe ser un valor numérico.',
            'porcentaje_avance.between' => 'El porcentaje debe estar entre 0 y 100.',
            'descripcion.required' => 'La descripción del avance es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 5000 caracteres.',
            'fecha.required' => 'La fecha del avance es obligatoria.',
            'fecha.date' => 'Debe ingresar una fecha válida.',
        ]);

        AvanceProyecto::create([
            'proyecto_id' => $proyecto->id,
            'porcentaje_avance' => $datos['porcentaje_avance'],
            'descripcion' => $datos['descripcion'],
            'fecha' => $datos['fecha'],
            'registrado_por_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('proyectos.avances.index', $proyecto)
            ->with('success', 'El avance se registró correctamente.');
    }

    public function edit(
        Request $request,
        Proyecto $proyecto,
        AvanceProyecto $avance
    ): View {
        $this->verificarResponsable($request, $proyecto);

        abort_unless(
            (int) $avance->proyecto_id === (int) $proyecto->id,
            404
        );

        return view(
            'avances.edit',
            compact('proyecto', 'avance')
        );
    }

    public function update(
        Request $request,
        Proyecto $proyecto,
        AvanceProyecto $avance
    ): RedirectResponse {
        $this->verificarResponsable($request, $proyecto);

        abort_unless(
            (int) $avance->proyecto_id === (int) $proyecto->id,
            404
        );

        $datos = $request->validate([
            'porcentaje_avance' => [
                'required',
                'numeric',
                'between:0,100',
            ],
            'descripcion' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],
            'fecha' => [
                'required',
                'date',
            ],
        ], [
            'porcentaje_avance.required' => 'El porcentaje de avance es obligatorio.',
            'porcentaje_avance.numeric' => 'El porcentaje debe ser numérico.',
            'porcentaje_avance.between' => 'El porcentaje debe estar entre 0 y 100.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 5000 caracteres.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'Debe ingresar una fecha válida.',
        ]);

        $avance->update($datos);

        return redirect()
            ->route('proyectos.avances.index', $proyecto)
            ->with('success', 'El avance se actualizó correctamente.');
    }
}

