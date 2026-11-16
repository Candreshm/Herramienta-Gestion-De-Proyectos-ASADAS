<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvanceProyecto extends Model
{
    protected $table = 'avance_proyectos';

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
            'porcentaje_avance' => 'decimal:2',
            'fecha' => 'date',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por_id');
    }
}
