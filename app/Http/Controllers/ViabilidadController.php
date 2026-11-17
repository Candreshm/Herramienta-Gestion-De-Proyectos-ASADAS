<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\EvaluacionProyecto;
use Illuminate\Http\Request;

class ViabilidadController extends Controller
{
    // HU-10: Ranking y priorización
    public function ranking(Request $request)
{
    $query = Proyecto::whereHas('evaluacion')
        ->with('evaluacion');

    if ($request->filled('buscar')) {
        $buscar = trim($request->buscar);

        $query->where(function ($q) use ($buscar) {
            $q->where('codigo', 'like', "%{$buscar}%")
                ->orWhere('nombre', 'like', "%{$buscar}%");
        });
    }

    if ($request->filled('dictamen')) {
        $query->whereHas('evaluacion', function ($q) use ($request) {
            $q->where('dictamen', $request->dictamen);
        });
    }

    $query->orderByDesc(
        EvaluacionProyecto::select('puntaje_total')
            ->whereColumn(
                'evaluaciones_proyecto.proyecto_id',
                'proyectos.id'
            )
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
    // Calcular viabilidad
    public function calcular($id)
    {
        $proyecto = Proyecto::with('evaluacion')->findOrFail($id);

        // evaluacion incompleta por si no existe o faltan notas
        if (!$proyecto->evaluacion) {
            return back()->with('error', 'No es posible calcular el dictamen: el proyecto no tiene evaluación.');
        }

        $eval = $proyecto->evaluacion;

        // promedio simple
        $puntajeTotal = ($eval->nota_tecnica + $eval->nota_financiera + $eval->nota_operativa + $eval->nota_normativa) / 4;
        $dictamen = $puntajeTotal >= 70 ? 'Viable' : 'No viable';

        // Guarda en la base de datos
        $eval->update([
            'puntaje_total' => $puntajeTotal,
            'dictamen' => $dictamen,
        ]);

        return back()->with('success', "Dictamen calculado: {$dictamen} con un puntaje de {$puntajeTotal}");
    }
}