<?php

namespace Database\Seeders;

use App\Models\ModeloViabilidad;
use Illuminate\Database\Seeder;

class ModeloViabilidadSeeder extends Seeder
{
    public function run(): void
    {
        ModeloViabilidad::updateOrCreate(
            [
                'nombre' => 'Modelo estándar ASADA',
            ],
            [
                'peso_tecnico' => 25.00,
                'peso_financiero' => 25.00,
                'peso_operativo' => 25.00,
                'peso_normativo' => 25.00,
                'umbral_viable' => 70.00,
                'activo' => true,
                'configurado_por_id' => null,
            ]
        );
    }
}