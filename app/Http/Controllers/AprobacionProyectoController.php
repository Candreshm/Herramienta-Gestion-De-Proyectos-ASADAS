<?php

namespace App\Http\Controllers;

use App\Models\AprobacionProyecto;
use App\Models\EstadoProyecto;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AprobacionProyectoController extends Controller
{
    public function edit(Proyecto $proyecto): View
    {
        $proyecto->load([
            'evaluacion',
            'validacionPresupuestaria',
            'aprobacion',
            'estado',
        ]);

        return view(
            'aprobaciones.edit',
            compact('proyecto')
        );
    }

    public function update(
        Request $request,
        Proyecto $proyecto
    ): RedirectResponse {
        $datos = $request->validate([
            'decision' => [
                'required',
                'in:Aprobado,Rechazado',
            ],
            'numero_acuerdo' => [
                'nullable',
                'string',
                'max:100',
            ],
            'fecha_acuerdo' => [
                'required',
                'date',
            ],
            'responsable' => [
                'required',
                'string',
                'max:150',
            ],
            'justificacion' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        $proyecto->load([
            'evaluacion',
            'validacionPresupuestaria',
        ]);

        if ($datos['decision'] === 'Aprobado') {

            if (!$proyecto->evaluacion) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'No es posible aprobar el proyecto porque no tiene una evaluación registrada.'
                    );
            }

            if ($proyecto->evaluacion->dictamen !== 'Viable') {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'No es posible aprobar el proyecto porque el dictamen de viabilidad no es Viable.'
                    );
            }

            if (!$proyecto->validacionPresupuestaria) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'No es posible aprobar el proyecto porque no tiene validación presupuestaria.'
                    );
            }

            if (
                !$proyecto
                    ->validacionPresupuestaria
                    ->tienePresupuestoSuficiente()
            ) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'No es posible aprobar el proyecto porque el presupuesto disponible es insuficiente.'
                    );
            }
        }

        DB::transaction(function () use (
            $datos,
            $request,
            $proyecto
        ) {
            AprobacionProyecto::updateOrCreate(
                [
                    'proyecto_id' => $proyecto->id,
                ],
                [
                    'decision' => $datos['decision'],
                    'numero_acuerdo' =>
                        $datos['numero_acuerdo'] ?? null,
                    'fecha_acuerdo' =>
                        $datos['fecha_acuerdo'],
                    'responsable' =>
                        $datos['responsable'],
                    'justificacion' =>
                        $datos['justificacion'],
                    'registrado_por_id' =>
                        $request->user()->id,
                ]
            );

            $estado = EstadoProyecto::where(
                'nombre',
                $datos['decision']
            )->firstOrFail();

            $proyecto->update([
                'estado_id' => $estado->id,
            ]);
        });

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with(
                'success',
                'La decisión del proyecto se registró correctamente.'
            );
    }
}