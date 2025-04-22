<script setup lang="ts">
import { ref, computed } from 'vue';
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';

import { useColorMode } from '@vueuse/core';
import { usePage } from '@inertiajs/vue3';
import { provide } from 'vue';

const handleLogout = async () => {
    try {
        await fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        });
        window.location.href = '/';
    } catch (error) {
        console.error('Logout failed:', error);
    }
};

const mode = useColorMode();
mode.value = 'dark';

const page = usePage();
const user = page.props.auth;

provide('user', user);

</script>

<template>
    <div>
        <NavigationMenu>
            <NavigationMenuList>

                <NavigationMenuItem>
                    <NavigationMenuLink :href="route('dashboard')" :class="navigationMenuTriggerStyle()">
                        Página Inicial
                    </NavigationMenuLink>
                </NavigationMenuItem>

                <NavigationMenuItem v-if="user.can.agenda_ver">
                    <NavigationMenuLink :href="route('profile.edit')" :class="navigationMenuTriggerStyle()">
                        Agenda
                    </NavigationMenuLink>
                </NavigationMenuItem>

                <NavigationMenuItem v-if="user.can.clientes_gerenciar">
                    <NavigationMenuLink :href="route('profile.edit')" :class="navigationMenuTriggerStyle()">
                        Clientes
                    </NavigationMenuLink>
                </NavigationMenuItem>

                <NavigationMenuItem v-if="user.can.vendas_gerenciar">
                    <NavigationMenuTrigger>Vendas</NavigationMenuTrigger>
                    <NavigationMenuContent>
                        <ul class="flex w-[400px] gap-3 p-4 md:w-[500px] lg:w-[600px]">
                            <li>
                                <NavigationMenuLink as-child v-if="user.can.venda_nova">
                                    <a href="/docs/introduction"
                                        class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground">
                                        <div class="text-sm font-medium leading-none">Nova venda</div>
                                    </a>
                                </NavigationMenuLink>
                            </li>
                            <li>
                                <NavigationMenuLink as-child v-if="user.can.vendas_andamento">
                                    <a href="/docs/ongoing-sales"
                                        class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground">
                                        <div class="text-sm font-medium leading-none">Vendas em andamento</div>
                                    </a>
                                </NavigationMenuLink>
                            </li>
                            <li>
                                <NavigationMenuLink as-child v-if="user.can.vendas_finalizadas">
                                    <a href="/docs/completed-sales"
                                        class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground">
                                        <div class="text-sm font-medium leading-none">Vendas finalizadas</div>
                                    </a>
                                </NavigationMenuLink>
                            </li>
                        </ul>
                    </NavigationMenuContent>
                </NavigationMenuItem>

                <NavigationMenuItem v-if="user.can.usuarios_gerenciar">
                    <NavigationMenuTrigger>Usuários</NavigationMenuTrigger>
                    <NavigationMenuContent>
                        <ul class="flex w-[400px] gap-3 p-4 md:w-[500px] lg:w-[600px]">
                            <li>
                                <NavigationMenuLink as-child>
                                    <a href="/docs/introduction"
                                        class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground">
                                        <div class="text-sm font-medium leading-none">Novo usuário</div>
                                    </a>
                                </NavigationMenuLink>
                            </li>
                            <li>
                                <NavigationMenuLink as-child>
                                    <a href="/docs/ongoing-sales"
                                        class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground">
                                        <div class="text-sm font-medium leading-none">Usuários</div>
                                    </a>
                                </NavigationMenuLink>
                            </li>
                        </ul>
                    </NavigationMenuContent>
                </NavigationMenuItem>

                <NavigationMenuItem v-if="user.can.perfil_editar">
                    <NavigationMenuLink :href="route('profile.edit')" :class="navigationMenuTriggerStyle()">
                        Seu Perfil
                    </NavigationMenuLink>
                </NavigationMenuItem>

                <NavigationMenuItem>
                    <NavigationMenuLink as="button" @click="handleLogout" :class="navigationMenuTriggerStyle()">
                        Sair
                    </NavigationMenuLink>
                </NavigationMenuItem>

            </NavigationMenuList>
        </NavigationMenu>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>
</template>
