<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->decimal('viabilidad_puntuacion', 5, 2)->nullable();
            $table->string('viabilidad_resultado', 30)->nullable();
            $table->timestamp('viabilidad_evaluada_at')->nullable();
            $table->foreignId('viabilidad_modelo_id')->nullable()->constrained('modelos_viabilidad')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropForeign(['viabilidad_modelo_id']);
            $table->dropColumn([
                'viabilidad_puntuacion',
                'viabilidad_resultado',
                'viabilidad_evaluada_at',
                'viabilidad_modelo_id',
            ]);
        });
    }
};
