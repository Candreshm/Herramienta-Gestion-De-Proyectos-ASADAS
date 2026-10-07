<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvidenciaProyecto extends Model
{
    protected $table = 'evidencias_proyecto';

    protected $fillable = [
        'proyecto_id',
        'nombre_original',
        'ruta',
        'tipo_mime',
        'tamano',
        'hash',
    ];

    protected function casts(): array
    {
        return [
            'tamano' => 'integer',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(
            Proyecto::class,
            'proyecto_id'
        );
    }
}
