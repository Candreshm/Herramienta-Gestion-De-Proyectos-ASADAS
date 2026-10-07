<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyecto extends Model
{
    protected $table = 'proyectos';

    protected $fillable = [
    'codigo',
    'nombre',
    'descripcion',
    'objetivo',
    'justificacion',
    'costo_estimado',
    'impacto_esperado',
    'nivel_riesgo',
    'criticidad',
    'prioridad',
    'estado_proyecto_id',
    'creado_por_id',
    'activo',
    ];

    protected function casts(): array
    {
         return [
            'costo_estimado' => 'decimal:2',
            'activo' => 'boolean',
         ];
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(
            EstadoProyecto::class,
            'estado_proyecto_id'
        );
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'creado_por_id'
        );
    }

    public function evidencias(): HasMany
    {
        return $this->hasMany(
            EvidenciaProyecto::class,
            'proyecto_id'
        );
}
}
