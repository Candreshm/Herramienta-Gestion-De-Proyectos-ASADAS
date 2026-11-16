<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hitos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->restrictOnDelete();

            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->date('fecha_planificada');
            $table->date('fecha_cumplimiento')->nullable();
            $table->string('estado', 30)->default('Pendiente');

            $table->foreignId('responsable_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hitos');
    }
};
