<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'


defineProps({
    users: {
        type: Array,
        required: true,
    }
});
</script>

<template>

    <Head title="Usuários" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800">

                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Nome</TableHead>
                                <TableHead>Email</TableHead>
                                <TableHead>Função</TableHead>
                                <TableHead class="text-right">Ações</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="user in users" :key="user.user_id">
                                <TableCell>{{ user.name }}</TableCell>
                                <TableCell>{{ user.email }}</TableCell>
                                <TableCell>{{ user.role }}</TableCell>
                                <TableCell class="text-right">
                                    <button class="text-blue-500 hover:underline">Editar</button>
                                    <button class="text-red-500 hover:underline ml-2">Excluir</button>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
