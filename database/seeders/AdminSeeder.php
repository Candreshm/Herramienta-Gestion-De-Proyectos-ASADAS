<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('nombre', 'Administrador')->firstOrFail();

        User::updateOrCreate(
            ['email' => 'admin@asada.local'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Admin1234!'),
                'role_id' => $adminRole->id,
                'activo' => true,
            ]
        );
    }
}