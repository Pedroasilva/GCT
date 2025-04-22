<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

import { ref } from 'vue';
import axios from 'axios';

defineProps({
    users: {
        type: Array,
        required: true,
    }
});

const editUser = (userId) => {
    localStorage.setItem('user_id', userId);
    window.location.href = `/users/edit`;
};

const deleteUser = async (userId) => {
    if (confirm('Tem certeza que deseja inativar este usuário?')) {
        try {
            await axios.delete(`/users/destroy/${userId}`);
            window.location.reload();
        } catch (error) {
            console.error('Erro ao inativar o usuário:', error);
        }
    }
};

const activateUser = async (userId) => {
    if (confirm('Tem certeza que deseja ativar este usuário?')) {
        try {
            await axios.put(`/users/activate/${userId}`);
            window.location.reload();
        } catch (error) {
            console.error('Erro ao ativar o usuário:', error);
        }
    }
};

const isEditable = (userId) => userId !== 1;
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
                            <TableRow
                                v-for="user in users"
                                :key="user.user_id"
                                :class="{'text-red-500': user.deleted_at}"
                            >
                                <TableCell>{{ user.name }}</TableCell>
                                <TableCell>{{ user.email }}</TableCell>
                                <TableCell>{{ user.role }}</TableCell>
                                <TableCell class="text-right">
                                    <template v-if="isEditable(user.user_id)">
                                        <template v-if="user.deleted_at">
                                            <button
                                                class="text-green-500 hover:underline ml-2"
                                                @click="activateUser(user.user_id)"
                                            >
                                                Ativar
                                            </button>
                                        </template>
                                        <template v-else>
                                            <a
                                                class="text-blue-500 hover:underline cursor-pointer"
                                                @click="editUser(user.user_id)"
                                            >
                                                Editar
                                            </a>
                                            <button
                                                class="text-red-500 hover:underline ml-2"
                                                @click="deleteUser(user.user_id)"
                                            >
                                                Inativar
                                            </button>
                                        </template>
                                    </template>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
