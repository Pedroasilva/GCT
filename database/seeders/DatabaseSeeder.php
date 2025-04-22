<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criação das roles
        $adminRole = Role::firstOrCreate(['name' => 'administrador']);
        $sellerRole = Role::firstOrCreate(['name' => 'vendedor']);

        // Criação do usuário administrador
        $adminUser = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@gct.com.br',
            'password' => bcrypt('123456789'),
        ]);
        $adminUser->assignRole($adminRole);

        // Criação do usuário vendedor
        $sellerUser = User::factory()->create([
            'name' => 'vendedor',
            'email' => 'vendedor@gct.com.br',
            'password' => bcrypt('123456789'),
        ]);
        $sellerUser->assignRole($sellerRole);
    }
}
