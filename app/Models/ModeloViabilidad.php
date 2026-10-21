<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModeloViabilidad extends Model
{
    protected $table = 'modelos_viabilidad';

    protected $fillable = [
        'nombre',
        'criterios',
        'umbral_minimo',
        'activo',
        'actualizado_por_id',
    ];

    protected function casts(): array
    {
        return [
            'criterios' => 'array',
            'umbral_minimo' => 'decimal:2',
            'activo' => 'boolean',
        ];
    }

    public function actualizadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actualizado_por_id');
    }

    public function proyectosEvaluados(): HasMany
    {
        return $this->hasMany(Proyecto::class, 'viabilidad_modelo_id');
    }
}
