<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


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

public function evaluacion()
{
    return $this->hasOne(
        EvaluacionProyecto::class,
        'proyecto_id'
    )->ofMany([
        'fecha_evaluacion' => 'max',
        'id' => 'max',
    ]);
}
    public function evidencias(): HasMany
    {
        return $this->hasMany(
            EvidenciaProyecto::class,
            'proyecto_id'
        );
    }

    public function evaluaciones(): HasMany
    {
        return $this->hasMany(
            EvaluacionProyecto::class,
            'proyecto_id'
        );
    }

    public function validacionPresupuestaria(): HasOne
{
    return $this->hasOne(
        ValidacionPresupuestaria::class,
        'proyecto_id'
    );
}

public function aprobacion(): HasOne
{
    return $this->hasOne(
        AprobacionProyecto::class,
        'proyecto_id'
    );
}

public function tareas(): HasMany
{
    return $this->hasMany(
        TareaProyecto::class,
        'proyecto_id'
    );
}
public function hitos(): HasMany
{
    return $this->hasMany(
        HitoProyecto::class,
        'proyecto_id'
    );
}

public function avances(): HasMany
{
    return $this->hasMany(
        AvanceProyecto::class,
        'proyecto_id'
    );
}

public function incidencias(): HasMany
{
    return $this->hasMany(
        IncidenciaProyecto::class,
        'proyecto_id'
    );
}
public function documentos(): HasMany
{
    return $this->hasMany(
        DocumentoProyecto::class,
        'proyecto_id'
    );
}
}
