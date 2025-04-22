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
            'name' => 'Pedro Augusto',
            'email' => 'pedrocaaugusto@gmail.com',
            'password' => bcrypt('15935700'),
        ]);
        $adminUser->assignRole($adminRole);

        // Criação do usuário vendedor
        $sellerUser = User::factory()->create([
            'name' => 'João Silva',
            'email' => 'joao.silva@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $sellerUser->assignRole($sellerRole);
    }
}
