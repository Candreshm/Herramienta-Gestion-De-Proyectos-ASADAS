<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvaluacionProyectoRequest;
use App\Models\EvaluacionProyecto;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EvaluacionProyectoController extends Controller
{
    public function index(Proyecto $proyecto): View
    {
        $evaluaciones = $proyecto->evaluaciones()
            ->with(['evaluador', 'criterios'])
            ->latest('fecha_evaluacion')
            ->get();

        return view('evaluaciones.index', compact(
            'proyecto',
            'evaluaciones'
        ));
    }

    public function create(Proyecto $proyecto): View
    {
        return view('evaluaciones.create', compact('proyecto'));
    }

    public function store(
        StoreEvaluacionProyectoRequest $request,
        Proyecto $proyecto
    ): RedirectResponse {
        $datos = $request->validated();

        DB::transaction(function () use ($datos, $request, $proyecto) {
            $evaluacion = EvaluacionProyecto::create([
                'proyecto_id' => $proyecto->id,
                'evaluador_id' => $request->user()->id,
                'fecha_evaluacion' => $datos['fecha_evaluacion'],
                'observaciones' => $datos['observaciones'] ?? null,
            ]);

            $nombresCriterios = [
                'tecnico' => 'Técnico',
                'financiero' => 'Financiero',
                'operativo' => 'Operativo',
                'normativo' => 'Normativo',
            ];

            foreach ($nombresCriterios as $clave => $nombre) {
                $evaluacion->criterios()->create([
                    'criterio' => $nombre,
                    'puntuacion' => $datos['criterios'][$clave],
                ]);
            }
        });

        return redirect()
            ->route('proyectos.evaluacion.index', $proyecto)
            ->with('success', 'La evaluación se registró correctamente.');
    }
}
