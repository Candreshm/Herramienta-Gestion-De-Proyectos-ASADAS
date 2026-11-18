<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos_proyecto', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->cascadeOnDelete();

            $table->foreignId('tipo_documento_id')
                ->constrained('tipos_documento')
                ->restrictOnDelete();

            $table->string('nombre_original', 255);
            $table->string('nombre_almacenado', 255);
            $table->string('ruta_archivo', 500);
            $table->string('mime_type', 150);
            $table->unsignedBigInteger('tamano_bytes');
            $table->string('hash_archivo', 64);

            $table->text('descripcion')
                ->nullable();

            $table->date('fecha_documento')
                ->nullable();

            $table->foreignId('subido_por_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->boolean('activo')
                ->default(true);

            $table->timestamps();

            $table->index([
                'proyecto_id',
                'tipo_documento_id',
                'activo',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos_proyecto');
    }
};