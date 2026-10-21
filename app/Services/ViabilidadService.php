<?php

namespace App\Services;

use App\Models\ModeloViabilidad;
use App\Models\Proyecto;
use InvalidArgumentException;

class ViabilidadService
{
    public const CRITERIOS = [
        'nivel_riesgo' => 'Riesgo',
        'criticidad' => 'Criticidad',
        'prioridad' => 'Prioridad',
        'costo_estimado' => 'Costo estimado',
    ];

    public function evaluar(Proyecto $proyecto, ModeloViabilidad $modelo): array
    {
        $total = 0.0;
        $pesoTotal = 0.0;
        $detalle = [];

        foreach ($modelo->criterios as $campo => $configuracion) {
            $peso = (float) ($configuracion['peso'] ?? 0);
            $valor = $this->puntuar($proyecto->{$campo}, $configuracion, $campo);
            $total += $valor * $peso;
            $pesoTotal += $peso;
            $detalle[$campo] = ['valor' => $proyecto->{$campo}, 'puntuacion' => $valor, 'peso' => $peso];
        }

        $puntuacion = $pesoTotal > 0 ? round($total / $pesoTotal, 2) : 0.0;
        $resultado = $puntuacion >= (float) $modelo->umbral_minimo ? 'Viable' : 'No viable';

        $proyecto->update([
            'viabilidad_puntuacion' => $puntuacion,
            'viabilidad_resultado' => $resultado,
            'viabilidad_evaluada_at' => now(),
            'viabilidad_modelo_id' => $modelo->id,
        ]);

        return compact('puntuacion', 'resultado', 'detalle');
    }

    private function puntuar(mixed $valor, array $configuracion, string $campo): float
    {
        if ($valor === null || $valor === '') {
            return 0.0;
        }

        if ($campo === 'costo_estimado') {
            $maximo = (float) ($configuracion['maximo'] ?? 0);
            if ($maximo <= 0) {
                return 0.0;
            }

            return max(0.0, min(100.0, 100 - ((float) $valor / $maximo * 100)));
        }

        return (float) ($configuracion['valores'][(string) $valor] ?? 0);
    }
}
