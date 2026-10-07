<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->text('justificacion')->nullable();
            $table->decimal('costo_estimado', 15, 2)->nullable();
            $table->text('impacto_esperado')->nullable();
            $table->string('nivel_riesgo', 50)->nullable();
            $table->string('criticidad', 50)->nullable();
            $table->string('prioridad', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropColumn([
                'justificacion',
                'costo_estimado',
                'impacto_esperado',
                'nivel_riesgo',
                'criticidad',
                'prioridad',
            ]);
        });
    }
};
