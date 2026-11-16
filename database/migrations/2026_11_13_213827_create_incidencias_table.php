<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->restrictOnDelete();

            $table->string('titulo', 150);
            $table->text('descripcion');
            $table->string('nivel_severidad', 20);
            $table->string('estado', 30)->default('Abierta');

            $table->date('fecha_registro');
            $table->date('fecha_resolucion')->nullable();

            $table->foreignId('registrado_por_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('responsable_id')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
