<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aprobaciones_proyecto', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proyecto_id')
                ->unique()
                ->constrained('proyectos')
                ->cascadeOnDelete();

            $table->enum('decision', [
                'Aprobado',
                'Rechazado',
            ]);

            $table->string('numero_acuerdo', 100)
                ->nullable();

            $table->date('fecha_acuerdo');

            $table->string('responsable', 150);

            $table->text('justificacion');

            $table->foreignId('registrado_por_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aprobaciones_proyecto');
    }
};
