<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Criação das permissões
        $permissions = ['agenda_gerenciar', 'perfil_gerenciar'];
        $vendedorPermissions = ['vendas_gerenciar'];
        $adminPermissions = ['usuarios_gerenciar'];

        // Criar todas as permissões
        foreach (array_merge($permissions, $vendedorPermissions, $adminPermissions) as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Criação do perfil administrador
        $adminRole = Role::create(['name' => 'administrador']);
        $adminRole->givePermissionTo(Permission::all()); // Todas as permissões

        // Criação do perfil vendedor
        $vendedorRole = Role::create(['name' => 'vendedor']);
        $vendedorRole->givePermissionTo(array_merge($permissions, $vendedorPermissions)); // Permissões específicas

        // Atribuir o papel de administrador ao usuário com o e-mail especificado
        $user = User::where('email', 'pedrocaaugusto@gmail.com')->first();
        if ($user) {
            $user->assignRole('administrador');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remover os perfis
        Role::whereIn('name', ['vendedor', 'administrador'])->delete();

        // Remover as permissões
        Permission::whereIn('name', [
            'ver agenda', 'editar perfil', 'trocar senha',
            'gerenciar vendas', 'nova venda', 'vendas em andamento', 'vendas finalizadas',
            'gerenciar usuarios'
        ])->delete();
    }
};
