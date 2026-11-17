<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvanceProyecto extends Model
{
    protected $table = 'avances_proyecto';

    protected $fillable = [
        'proyecto_id',
        'porcentaje_avance',
        'descripcion',
        'fecha',
        'registrado_por_id',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'porcentaje_avance' => 'integer',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'registrado_por_id'
        );
    }
}