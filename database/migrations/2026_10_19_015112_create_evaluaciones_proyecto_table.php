<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evaluaciones_proyecto', function (Blueprint $table) {
            $table->integer('nota_tecnica')->default(0);
            $table->integer('nota_financiera')->default(0);
            $table->integer('nota_operativa')->default(0);
            $table->integer('nota_normativa')->default(0);
            $table->decimal('puntaje_total', 5, 2)->nullable();
            $table->string('dictamen')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('evaluaciones_proyecto', function (Blueprint $table) {
            $table->dropColumn([
                'nota_tecnica',
                'nota_financiera',
                'nota_operativa',
                'nota_normativa',
                'puntaje_total',
                'dictamen',
            ]);
        });
    }
};