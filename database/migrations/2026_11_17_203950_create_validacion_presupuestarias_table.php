<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('validaciones_presupuestarias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proyecto_id')
                ->unique()
                ->constrained('proyectos')
                ->cascadeOnDelete();

            $table->decimal('monto_disponible', 14, 2)
                ->default(0);

            $table->date('fecha_validacion');

            $table->text('observaciones')
                ->nullable();

            $table->foreignId('validado_por_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'validaciones_presupuestarias'
        );
    }
};