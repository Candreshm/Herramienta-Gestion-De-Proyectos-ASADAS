<?php

namespace Database\Seeders;

use App\Models\EstadoProyecto;
use Illuminate\Database\Seeder;

class EstadoProyectoSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            [
                'nombre' => 'Registrado',
                'orden' => 1,
                'activo' => true,
            ],
            [
                'nombre' => 'En análisis',
                'orden' => 2,
                'activo' => true,
            ],
            [
                'nombre' => 'Priorizado',
                'orden' => 3,
                'activo' => true,
            ],
            [
                'nombre' => 'Aprobado',
                'orden' => 4,
                'activo' => true,
            ],
            [
                'nombre' => 'En ejecución',
                'orden' => 5,
                'activo' => true,
            ],
            [
                'nombre' => 'Pausado',
                'orden' => 6,
                'activo' => true,
            ],
            [
                'nombre' => 'Finalizado',
                'orden' => 7,
                'activo' => true,
            ],
            [
                'nombre' => 'Rechazado',
                'orden' => 8,
                'activo' => true,
            ],
        ];

        foreach ($estados as $estado) {
            EstadoProyecto::create($estado);
        }
    }
}