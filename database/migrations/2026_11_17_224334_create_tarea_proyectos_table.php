<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tareas_proyecto', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->cascadeOnDelete();

            $table->string('titulo', 150);

            $table->text('descripcion')
                ->nullable();

            $table->foreignId('responsable_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->date('fecha_inicio')
                ->nullable();

            $table->date('fecha_vencimiento')
                ->nullable();

            $table->enum('estado', [
                'Pendiente',
                'En progreso',
                'Completada',
            ])->default('Pendiente');

            $table->timestamps();

            $table->index([
                'proyecto_id',
                'estado',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas_proyecto');
    }
};