<?php

namespace App\Http\Controllers;

use App\Models\EvaluacionProyecto;
use App\Models\ModeloViabilidad;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ViabilidadController extends Controller
{
    public function ranking(Request $request): View
    {
        $query = Proyecto::whereHas('evaluacion')
            ->with([
                'evaluacion.criterios',
            ]);

        if ($request->filled('buscar')) {
            $buscar = trim($request->buscar);

            $query->where(function ($q) use ($buscar) {
                $q->where(
                    'codigo',
                    'like',
                    "%{$buscar}%"
                )->orWhere(
                    'nombre',
                    'like',
                    "%{$buscar}%"
                );
            });
        }

        if ($request->filled('dictamen')) {
            $query->whereHas(
                'evaluacion',
                function ($q) use ($request) {
                    $q->where(
                        'dictamen',
                        $request->dictamen
                    );
                }
            );
        }

        $query->orderByDesc(
            EvaluacionProyecto::select('puntaje_total')
                ->whereColumn(
                    'evaluaciones_proyecto.proyecto_id',
                    'proyectos.id'
                )
                ->latest('fecha_evaluacion')
                ->limit(1)
        );

        $proyectos = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'viabilidad.ranking',
            compact('proyectos')
        );
    }

    public function calcular(int $id): RedirectResponse
    {
        $proyecto = Proyecto::with([
            'evaluacion.criterios',
        ])->findOrFail($id);

        if (!$proyecto->evaluacion) {
            return back()->with(
                'error',
                'No es posible calcular el dictamen: el proyecto no tiene evaluación.'
            );
        }

        $modelo = ModeloViabilidad::where(
            'activo',
            true
        )->latest('id')->first();

        if (!$modelo) {
            return back()->with(
                'error',
                'No existe un modelo de viabilidad activo.'
            );
        }

        if (abs($modelo->suma_pesos - 100) > 0.01) {
            return back()->with(
                'error',
                'El modelo de viabilidad activo no suma 100 % en sus ponderaciones.'
            );
        }

        $evaluacion = $proyecto->evaluacion;

        $criterios = $evaluacion
            ->criterios
            ->keyBy(
                fn ($criterio) =>
                    mb_strtolower($criterio->criterio)
            );

        $tecnico = $criterios->get('técnico');
        $financiero = $criterios->get('financiero');
        $operativo = $criterios->get('operativo');
        $normativo = $criterios->get('normativo');

        if (
            !$tecnico ||
            !$financiero ||
            !$operativo ||
            !$normativo
        ) {
            return back()->with(
                'error',
                'La evaluación está incompleta y no contiene todos los criterios requeridos.'
            );
        }

        $puntajeTecnico =
            $this->convertirAPorcentaje(
                $tecnico->puntuacion
            );

        $puntajeFinanciero =
            $this->convertirAPorcentaje(
                $financiero->puntuacion
            );

        $puntajeOperativo =
            $this->convertirAPorcentaje(
                $operativo->puntuacion
            );

        $puntajeNormativo =
            $this->convertirAPorcentaje(
                $normativo->puntuacion
            );

        $puntajeTotal =
            ($puntajeTecnico *
                ((float) $modelo->peso_tecnico / 100))
            +
            ($puntajeFinanciero *
                ((float) $modelo->peso_financiero / 100))
            +
            ($puntajeOperativo *
                ((float) $modelo->peso_operativo / 100))
            +
            ($puntajeNormativo *
                ((float) $modelo->peso_normativo / 100));

        $puntajeTotal = round(
            $puntajeTotal,
            2
        );

        $dictamen =
            $puntajeTotal >=
            (float) $modelo->umbral_viable
                ? 'Viable'
                : 'No viable';

        $evaluacion->update([
            'puntaje_total' => $puntajeTotal,
            'dictamen' => $dictamen,
        ]);

        return back()->with(
            'success',
            sprintf(
                'Dictamen calculado: %s con un puntaje de %.2f%%.',
                $dictamen,
                $puntajeTotal
            )
        );
    }

    private function convertirAPorcentaje(
        int $puntuacion
    ): float {
        if (
            $puntuacion < 1 ||
            $puntuacion > 5
        ) {
            abort(
                422,
                'La puntuación de los criterios debe estar entre 1 y 5.'
            );
        }

        return $puntuacion * 20;
    }
}