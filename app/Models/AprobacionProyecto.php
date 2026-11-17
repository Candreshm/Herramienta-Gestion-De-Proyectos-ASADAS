<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AprobacionProyecto extends Model
{
    protected $table = 'aprobaciones_proyecto';

    protected $fillable = [
        'proyecto_id',
        'decision',
        'numero_acuerdo',
        'fecha_acuerdo',
        'responsable',
        'justificacion',
        'registrado_por_id',
    ];

    protected function casts(): array
    {
        return [
            'fecha_acuerdo' => 'date',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(
            Proyecto::class,
            'proyecto_id'
        );
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'registrado_por_id'
        );
    }
}