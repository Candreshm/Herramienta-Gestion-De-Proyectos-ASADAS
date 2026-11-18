<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ValidacionPresupuestaria extends Model
{
    protected $table =
        'validaciones_presupuestarias';

    protected $fillable = [
        'proyecto_id',
        'monto_disponible',
        'fecha_validacion',
        'observaciones',
        'validado_por_id',
    ];

    protected function casts(): array
    {
        return [
            'monto_disponible' => 'decimal:2',
            'fecha_validacion' => 'date',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(
            Proyecto::class,
            'proyecto_id'
        );
    }

    public function validadoPor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'validado_por_id'
        );
    }

    public function tienePresupuestoSuficiente(): bool
    {
        $costoEstimado =
            (float) ($this->proyecto?->costo_estimado ?? 0);

        return
            $costoEstimado > 0 &&
            (float) $this->monto_disponible >=
            $costoEstimado;
    }
}