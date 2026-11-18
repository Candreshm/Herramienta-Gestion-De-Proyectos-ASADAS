<?php

namespace Database\Seeders;

use App\Models\Proyecto;
use App\Models\EvaluacionProyecto;
use Illuminate\Database\Seeder;

class EvaluacionSeeder extends Seeder
{
    public function run(): void
    {
        // crea dos proyectos de prueba
        $proyecto1 = Proyecto::firstOrCreate(
            ['nombre' => 'Mejora del Tanque de Agua'],
            ['estado_proyecto_id' => 1, 'descripcion' => 'Proyecto de prueba 1'] // Ajusta según tu tabla
        );

        $proyecto2 = Proyecto::firstOrCreate(
            ['nombre' => 'Cambio de Tuberías'],
            ['estado_proyecto_id' => 1, 'descripcion' => 'Proyecto de prueba 2']
        );

        // se le asigna evaluaciones
        // proyecto 1: excelentes notas
        EvaluacionProyecto::updateOrCreate(
            ['proyecto_id' => $proyecto1->id],
            [
                'nota_tecnica' => 85,
                'nota_financiera' => 90,
                'nota_operativa' => 80,
                'nota_normativa' => 95,
            ]
        );

        // proyecto 2: notas regulares
        EvaluacionProyecto::updateOrCreate(
            ['proyecto_id' => $proyecto2->id],
            [
                'nota_tecnica' => 60,
                'nota_financiera' => 50,
                'nota_operativa' => 70,
                'nota_normativa' => 65,
            ]
        );
    }
}