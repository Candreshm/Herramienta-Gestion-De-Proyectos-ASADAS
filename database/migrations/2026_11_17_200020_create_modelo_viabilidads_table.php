<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modelos_viabilidad', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 100);

            $table->decimal('peso_tecnico', 5, 2)->default(25.00);
            $table->decimal('peso_financiero', 5, 2)->default(25.00);
            $table->decimal('peso_operativo', 5, 2)->default(25.00);
            $table->decimal('peso_normativo', 5, 2)->default(25.00);

            $table->decimal('umbral_viable', 5, 2)->default(70.00);

            $table->boolean('activo')->default(false);

            $table->foreignId('configurado_por_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modelos_viabilidad');
    }
};