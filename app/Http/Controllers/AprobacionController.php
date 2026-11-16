<?php

namespace App\Http\Controllers;

use App\Models\Aprobacion;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AprobacionController extends Controller
{
    private function verificarAcceso(Request $request): void
    {
        $usuario = $request->user();

        abort_unless(
            $usuario &&
            $usuario->activo &&
            in_array(
                $usuario->role?->nombre,
                ['Administrador', 'Secretaría'],
                true
            ),
            403,
            'No tiene permisos para gestionar acuerdos.'
        );
    }

    public function index(
        Request $request,
        Proyecto $proyecto
    ): View {
        $this->verificarAcceso($request);

        $aprobaciones = $proyecto->aprobaciones()
            ->with(['responsable', 'registradoPor'])
            ->orderByDesc('fecha_acuerdo')
            ->get();

        return view(
            'aprobaciones.index',
            compact('proyecto', 'aprobaciones')
        );
    }

    public function create(
        Request $request,
        Proyecto $proyecto
    ): View {
        $this->verificarAcceso($request);

        $usuarios = User::where('activo', true)
            ->orderBy('name')
            ->get();

        return view(
            'aprobaciones.create',
            compact('proyecto', 'usuarios')
        );
    }

    public function store(
        Request $request,
        Proyecto $proyecto
    ): RedirectResponse {
        $this->verificarAcceso($request);

        $datos = $request->validate([
            'tipo_decision' => [
                'required',
                Rule::in(['APROBADO', 'RECHAZADO', 'DEVUELTO']),
            ],
            'fecha_acuerdo' => [
                'required',
                'date',
            ],
            'responsable_id' => [
                'required',
                Rule::exists('users', 'id')->where('activo', true),
            ],
            'justificacion' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],
        ], [
            'tipo_decision.required' => 'Debe seleccionar una decisión.',
            'tipo_decision.in' => 'El tipo de decisión seleccionado no es válido.',
            'fecha_acuerdo.required' => 'La fecha del acuerdo es obligatoria.',
            'fecha_acuerdo.date' => 'Debe ingresar una fecha válida.',
            'responsable_id.required' => 'Debe seleccionar un responsable.',
            'responsable_id.exists' => 'El responsable seleccionado no existe o está inactivo.',
            'justificacion.required' => 'La justificación es obligatoria.',
            'justificacion.min' => 'La justificación debe tener al menos 10 caracteres.',
            'justificacion.max' => 'La justificación no puede superar los 5000 caracteres.',
        ]);

        Aprobacion::create([
            'proyecto_id' => $proyecto->id,
            'tipo_decision' => $datos['tipo_decision'],
            'fecha_acuerdo' => $datos['fecha_acuerdo'],
            'responsable_id' => $datos['responsable_id'],
            'justificacion' => $datos['justificacion'],
            'registrado_por_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('proyectos.aprobaciones.index', $proyecto)
            ->with('success', 'El acuerdo se registró correctamente.');
    }
}

