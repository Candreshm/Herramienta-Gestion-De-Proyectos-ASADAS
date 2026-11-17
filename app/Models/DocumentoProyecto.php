<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentoProyecto extends Model
{
    protected $table = 'documentos_proyecto';

    protected $fillable = [
        'proyecto_id',
        'tipo_documento_id',
        'nombre_original',
        'nombre_almacenado',
        'ruta_archivo',
        'mime_type',
        'tamano_bytes',
        'hash_archivo',
        'descripcion',
        'fecha_documento',
        'subido_por_id',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'fecha_documento' => 'date',
            'activo' => 'boolean',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(
            Proyecto::class,
            'proyecto_id'
        );
    }

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(
            TipoDocumento::class,
            'tipo_documento_id'
        );
    }

    public function subidoPor(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'subido_por_id'
        );
    }
}