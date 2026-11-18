<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hitos_proyecto', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->cascadeOnDelete();

            $table->string('nombre', 150);

            $table->text('descripcion')
                ->nullable();

            $table->date('fecha_planificada');

            $table->date('fecha_cumplimiento')
                ->nullable();

            $table->enum('estado', [
                'Pendiente',
                'En progreso',
                'Cumplido',
                'Atrasado',
            ])->default('Pendiente');

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
        Schema::dropIfExists('hitos_proyecto');
    }
};