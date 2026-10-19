<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EvaluacionProyecto extends Model
{
    protected $table = 'evaluaciones_proyecto';

    protected $fillable = [
        'proyecto_id',
        'evaluador_id',
        'fecha_evaluacion',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_evaluacion' => 'date',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function evaluador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluador_id');
    }

    public function criterios(): HasMany
    {
        return $this->hasMany(
            EvaluacionCriterio::class,
            'evaluacion_proyecto_id'
        );
    }
}
