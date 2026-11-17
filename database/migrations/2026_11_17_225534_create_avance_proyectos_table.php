<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avances_proyecto', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proyecto_id')
                ->constrained('proyectos')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('porcentaje_avance');

            $table->text('descripcion');

            $table->date('fecha');

            $table->foreignId('registrado_por_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();

            $table->index([
                'proyecto_id',
                'fecha',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avances_proyecto');
    }
};
