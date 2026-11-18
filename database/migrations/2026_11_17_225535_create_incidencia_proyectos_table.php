<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidencias_proyecto', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->cascadeOnDelete();

            $table->string('titulo', 150);

            $table->text('descripcion');

            $table->enum('nivel_severidad', [
                'Baja',
                'Media',
                'Alta',
                'Crítica',
            ])->default('Media');

            $table->enum('estado', [
                'Abierta',
                'En atención',
                'Resuelta',
            ])->default('Abierta');

            $table->date('fecha_registro');

            $table->date('fecha_resolucion')
                ->nullable();

            $table->foreignId('registrado_por_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('responsable_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index([
                'proyecto_id',
                'estado',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidencias_proyecto');
    }
};