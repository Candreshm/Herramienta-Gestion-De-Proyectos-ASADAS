<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluacion_criterios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('evaluacion_proyecto_id')
                ->constrained('evaluaciones_proyecto')
                ->cascadeOnDelete();

            $table->string('criterio', 30);
            $table->unsignedTinyInteger('puntuacion');
            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->unique(
                ['evaluacion_proyecto_id', 'criterio'],
                'evaluacion_criterio_unico'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluacion_criterios');
    }
};
