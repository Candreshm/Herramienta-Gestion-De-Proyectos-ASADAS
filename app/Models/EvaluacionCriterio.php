<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluacionCriterio extends Model
{
    protected $table = 'evaluacion_criterios';

    protected $fillable = [
        'evaluacion_proyecto_id',
        'criterio',
        'puntuacion',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'puntuacion' => 'integer',
        ];
    }

    public function evaluacion(): BelongsTo
    {
        return $this->belongsTo(
            EvaluacionProyecto::class,
            'evaluacion_proyecto_id'
        );
    }
}
