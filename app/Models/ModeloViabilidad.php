<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModeloViabilidad extends Model
{
    protected $table = 'modelos_viabilidad';

    protected $fillable = [
        'nombre',
        'peso_tecnico',
        'peso_financiero',
        'peso_operativo',
        'peso_normativo',
        'umbral_viable',
        'activo',
        'configurado_por_id',
    ];

    protected function casts(): array
    {
        return [
            'peso_tecnico' => 'decimal:2',
            'peso_financiero' => 'decimal:2',
            'peso_operativo' => 'decimal:2',
            'peso_normativo' => 'decimal:2',
            'umbral_viable' => 'decimal:2',
            'activo' => 'boolean',
        ];
    }

    public function configuradoPor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'configurado_por_id'
        );
    }

    public function getSumaPesosAttribute(): float
    {
        return
            (float) $this->peso_tecnico +
            (float) $this->peso_financiero +
            (float) $this->peso_operativo +
            (float) $this->peso_normativo;
    }
}