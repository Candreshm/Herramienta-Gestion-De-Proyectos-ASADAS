<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('validaciones_presupuestarias')) {
            return;
        }

        Schema::table('validaciones_presupuestarias', function (Blueprint $table) {
            if (! Schema::hasColumn('validaciones_presupuestarias', 'proyecto_id')) {
                $table->foreignId('proyecto_id')
                    ->after('id')
                    ->constrained('proyectos')
                    ->cascadeOnDelete();
            }

            if (! Schema::hasColumn('validaciones_presupuestarias', 'monto_disponible')) {
                $table->decimal('monto_disponible', 14, 2)
                    ->default(0)
                    ->after('proyecto_id');
            }

            if (! Schema::hasColumn('validaciones_presupuestarias', 'fecha_validacion')) {
                $table->date('fecha_validacion')
                    ->after('monto_disponible');
            }

            if (! Schema::hasColumn('validaciones_presupuestarias', 'observaciones')) {
                $table->text('observaciones')
                    ->nullable()
                    ->after('fecha_validacion');
            }

            if (! Schema::hasColumn('validaciones_presupuestarias', 'validado_por_id')) {
                $table->foreignId('validado_por_id')
                    ->after('observaciones')
                    ->constrained('users')
                    ->restrictOnDelete();
            }
        });
    }

    public function down(): void
    {
        // Migración correctiva histórica.
        // No se revierte para evitar eliminar columnas
        // creadas originalmente por la migración base.
    }
};