<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cria a permissão
        $permission = Permission::create(['name' => 'clientes_gerenciar']);

        // Busca a role 'administrador'
        $adminRole = Role::where('name', 'administrador')->first();

        // Associa a permissão à role 'administrador'
        if ($adminRole) {
            $adminRole->givePermissionTo($permission);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a permissão da role 'administrador'
        $adminRole = Role::where('name', 'administrador')->first();
        if ($adminRole) {
            $adminRole->revokePermissionTo('clientes_gerenciar');
        }

        // Remove a permissão
        Permission::where('name', 'clientes_gerenciar')->delete();
    }
};
