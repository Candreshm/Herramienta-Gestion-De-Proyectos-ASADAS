<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HitoProyecto extends Model
{
    protected $table = 'hitos_proyecto';

    protected $fillable = [
        'proyecto_id',
        'nombre',
        'descripcion',
        'fecha_planificada',
        'fecha_cumplimiento',
        'estado',
        'responsable_id',
    ];

    protected function casts(): array
    {
        return [
            'fecha_planificada' => 'date',
            'fecha_cumplimiento' => 'date',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'responsable_id'
        );
    }
}
