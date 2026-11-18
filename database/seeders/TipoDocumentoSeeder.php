<?php

namespace Database\Seeders;

use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'Acta',
            'Cotización',
            'Contrato',
            'Factura',
            'Fotografía',
            'Informe',
            'Estudio técnico',
            'Otro',
        ];

        foreach ($tipos as $tipo) {
            TipoDocumento::updateOrCreate(
                ['nombre' => $tipo],
                ['activo' => true]
            );
        }
    }
}