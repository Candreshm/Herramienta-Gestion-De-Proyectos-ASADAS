<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TareaProyecto extends Model
{
    protected $table = 'tareas_proyecto';

    protected $fillable = [
        'proyecto_id',
        'titulo',
        'descripcion',
        'responsable_id',
        'fecha_inicio',
        'fecha_vencimiento',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_vencimiento' => 'date',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(
            Proyecto::class,
            'proyecto_id'
        );
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'responsable_id'
        );
    }
}