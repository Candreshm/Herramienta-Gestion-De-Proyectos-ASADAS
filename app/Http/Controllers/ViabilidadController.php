<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\EvaluacionProyecto;
use Illuminate\Http\Request;

class ViabilidadController extends Controller
{
    // HU-10: Ranking y priorización
    public function ranking()
    {
        // Trae los proyectos que ya tienen evaluacion y los ordena del mejor al peor por el puntuaje
        $proyectos = Proyecto::whereHas('evaluacion')
            ->with('evaluacion')
            ->get()
            ->sortByDesc(function($proyecto) {
                return $proyecto->evaluacion->puntaje_total;
            });

        // Si no hay manda un mensaje
        if ($proyectos->isEmpty()) {
            return view('viabilidad.ranking', ['proyectos' => $proyectos, 'mensaje' => 'No hay datos suficientes para generar la priorización.']);
        }

        return view('viabilidad.ranking', compact('proyectos'));
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