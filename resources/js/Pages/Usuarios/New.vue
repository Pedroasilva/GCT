<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NovoUsuarioForm from './Partials/NovoUsuarioForm.vue';
</script>

<template>

    <Head title="Novo Usuário" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">
                    <NovoUsuarioForm
                        :status="status"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
