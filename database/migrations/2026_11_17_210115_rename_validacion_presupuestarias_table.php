<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename(
            'validacion_presupuestarias',
            'validaciones_presupuestarias'
        );
    }

    public function down(): void
    {
        Schema::rename(
            'validaciones_presupuestarias',
            'validacion_presupuestarias'
        );
    }
};