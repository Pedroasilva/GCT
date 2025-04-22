<script setup lang="ts">
import { inject } from 'vue';
const user = inject('user');
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Perfil
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                <span class="text-green-500 font-bold">
                    {{ user.role ? user.role.charAt(0).toUpperCase() + user.role.slice(1) : 'N/A' }}
                </span>
            </p>
        </header>
    </section>
</template>
