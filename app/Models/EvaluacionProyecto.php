<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluacionProyecto extends Model
{
    protected $table = 'evaluaciones_proyecto';

    protected $fillable = [
        'proyecto_id', 'nota_tecnica', 'nota_financiera', 
        'nota_operativa', 'nota_normativa', 'puntaje_total', 'dictamen'
    ];

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }
}