<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('validaciones_presupuestarias', function (Blueprint $table) {

            $table->foreignId('proyecto_id')
                ->after('id')
                ->constrained('proyectos')
                ->cascadeOnDelete();

            $table->decimal('monto_disponible', 14, 2)
                ->default(0)
                ->after('proyecto_id');

            $table->date('fecha_validacion')
                ->after('monto_disponible');

            $table->text('observaciones')
                ->nullable()
                ->after('fecha_validacion');

            $table->foreignId('validado_por_id')
                ->after('observaciones')
                ->constrained('users')
                ->restrictOnDelete();

            $table->unique('proyecto_id');
        });
    }

    public function down(): void
    {
        Schema::table('validaciones_presupuestarias', function (Blueprint $table) {

            $table->dropUnique([
                'proyecto_id'
            ]);

            $table->dropConstrainedForeignId(
                'validado_por_id'
            );

            $table->dropConstrainedForeignId(
                'proyecto_id'
            );

            $table->dropColumn([
                'monto_disponible',
                'fecha_validacion',
                'observaciones',
            ]);
        });
    }
};