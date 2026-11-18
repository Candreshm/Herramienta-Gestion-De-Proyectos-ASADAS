<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->text('descripcion');
            $table->dateTime('fecha_vencimiento');
            $table->string('estado')->default('Pendiente');

            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->restrictOnDelete();

            $table->foreignId('responsable_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('creado_por_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();

            $table->index('proyecto_id');
            $table->index('estado');
            $table->index('responsable_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
