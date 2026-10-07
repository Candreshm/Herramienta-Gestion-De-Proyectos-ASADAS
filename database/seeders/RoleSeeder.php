<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(
            ['nombre' => 'Administrador'],
            [
                'descripcion' => 'Administra usuarios y configuración general del sistema.',
                'activo' => true,
            ]
        );

        Role::updateOrCreate(
            ['nombre' => 'Gerencia'],
            [
                'descripcion' => 'Consulta y gestiona información estratégica de proyectos.',
                'activo' => true,
            ]
        );

        Role::updateOrCreate(
            ['nombre' => 'Evaluador'],
            [
                'descripcion' => 'Participa en evaluaciones de viabilidad de proyectos.',
                'activo' => true,
            ]
        );

        Role::updateOrCreate(
            ['nombre' => 'Secretaría'],
            [
                'descripcion' => 'Apoya el registro y gestión administrativa.',
                'activo' => true,
            ]
        );

        Role::updateOrCreate(
            ['nombre' => 'Consulta'],
            [
                'descripcion' => 'Acceso de consulta según permisos asignados.',
                'activo' => true,
            ]
        );
    }
}
