<script setup>
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth;
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Perfil
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                <span class="text-green-500 font-bold">{{ user.role.charAt(0).toUpperCase() + user.role.slice(1) }}</span>
            </p>
        </header>
    </section>
</template>
