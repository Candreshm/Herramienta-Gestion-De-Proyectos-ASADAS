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
            $table->string('nombre')->default('Modelo de viabilidad');
            $table->json('criterios');
            $table->decimal('umbral_minimo', 5, 2);
            $table->boolean('activo')->default(true);
            $table->foreignId('actualizado_por_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modelos_viabilidad');
    }
};
