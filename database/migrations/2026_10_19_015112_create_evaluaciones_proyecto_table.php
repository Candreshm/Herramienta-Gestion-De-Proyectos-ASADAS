<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluaciones_proyecto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
            // Calificaciones del 1 al 100
            $table->integer('nota_tecnica')->default(0);
            $table->integer('nota_financiera')->default(0);
            $table->integer('nota_operativa')->default(0);
            $table->integer('nota_normativa')->default(0);
            // Resultados calculados (HU-09)
            $table->decimal('puntaje_total', 5, 2)->nullable();
            $table->string('dictamen')->nullable(); // 'Viable', 'No viable', 'En revisión'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluaciones_proyecto');
    }
};