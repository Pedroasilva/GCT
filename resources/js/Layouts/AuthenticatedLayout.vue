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

const showingNavigationDropdown = ref(false);

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

                <NavigationMenuItem>
                    <NavigationMenuLink :href="route('profile.edit')" :class="navigationMenuTriggerStyle()">
                        Agenda
                    </NavigationMenuLink>
                </NavigationMenuItem>

                <NavigationMenuItem>
                    <NavigationMenuTrigger>Vendas</NavigationMenuTrigger>
                    <NavigationMenuContent>
                        <ul class="flex w-[400px] gap-3 p-4 md:w-[500px] lg:w-[600px]">
                            <li>
                                <NavigationMenuLink as-child>
                                    <a href="/docs/introduction"
                                        class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground">
                                        <div class="text-sm font-medium leading-none">Nova venda</div>
                                    </a>
                                </NavigationMenuLink>
                            </li>
                            <li>
                                <NavigationMenuLink as-child>
                                    <a href="/docs/ongoing-sales"
                                        class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground">
                                        <div class="text-sm font-medium leading-none">Vendas em andamento</div>
                                    </a>
                                </NavigationMenuLink>
                            </li>
                            <li>
                                <NavigationMenuLink as-child>
                                    <a href="/docs/completed-sales"
                                        class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground">
                                        <div class="text-sm font-medium leading-none">Vendas finalizadas</div>
                                    </a>
                                </NavigationMenuLink>
                            </li>
                        </ul>
                    </NavigationMenuContent>
                </NavigationMenuItem>

                <NavigationMenuItem>
                    <NavigationMenuTrigger>Clientes</NavigationMenuTrigger>
                    <NavigationMenuContent>
                        <ul
                            class="grid gap-3 p-6 md:w-[400px] lg:w-[500px] lg:grid-cols-[minmax(0,.75fr)_minmax(0,1fr)]">
                            <li>
                                <NavigationMenuLink as-child>
                                    <a href="/docs/introduction"
                                        class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground">
                                        <div class="text-sm font-medium leading-none">Introduction</div>
                                        <p class="line-clamp-2 text-sm leading-snug text-muted-foreground">
                                            Re-usable components built using Radix UI and Tailwind CSS.
                                        </p>
                                    </a>
                                </NavigationMenuLink>
                            </li>
                        </ul>
                    </NavigationMenuContent>
                </NavigationMenuItem>

                <NavigationMenuItem>
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
