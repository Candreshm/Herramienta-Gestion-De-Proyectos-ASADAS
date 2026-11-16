<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incidencia extends Model
{
    protected $table = 'incidencias';

    protected $fillable = [
        'proyecto_id',
        'titulo',
        'descripcion',
        'nivel_severidad',
        'estado',
        'fecha_registro',
        'fecha_resolucion',
        'registrado_por_id',
        'responsable_id',
    ];

    protected function casts(): array
    {
        return [
            'fecha_registro' => 'date',
            'fecha_resolucion' => 'date',
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

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
