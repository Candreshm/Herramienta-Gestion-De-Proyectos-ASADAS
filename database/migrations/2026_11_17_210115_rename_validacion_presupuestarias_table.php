<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasTable('validacion_presupuestarias') &&
            !Schema::hasTable('validaciones_presupuestarias')
        ) {
            Schema::rename(
                'validacion_presupuestarias',
                'validaciones_presupuestarias'
            );
        }
    }

    public function down(): void
    {
        if (
            Schema::hasTable('validaciones_presupuestarias') &&
            !Schema::hasTable('validacion_presupuestarias')
        ) {
            Schema::rename(
                'validaciones_presupuestarias',
                'validacion_presupuestarias'
            );
        }
    }
};