<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Pedro Augusto',
            'email' => 'pedrocaaugusto@gmail.com',
            'password' => bcrypt('15935700'),
        ]);
    }
}
