<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    roles: {
        type: Array,
        required: true,
    },
    user: {
        type: Object,
        default: () => ({
            name: '',
            email: '',
            role: '',
        }),
    },
    user_id: {
        type: String,
        default: '',
    },
});

if (props.user_id) {
    props.user.id = props.user_id;

    fetch(`/users/show/${props.user.id}`)
        .then((response) => response.json())
        .then((data) => {
            form.name = data.name;
            form.email = data.email;
            form.role = data.role;
            form.id = data.id;
        })
        .catch((error) => {
            console.error('Error fetching user data:', error);
        });

}

const generateRandomPassword = () => {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let password = '';
    for (let i = 0; i < 12; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return password;
};

const form = useForm({
    name: props.user.name || '',
    email: props.user.email || '',
    password: generateRandomPassword(),
    role: props.user.role || '',
    id: props.user.id || '',
});

const saveUser = () => {
    if (props.user.id) {
        form.put(route('users.update', props.user.id), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                localStorage.removeItem('user_id');
            },
        });
    } else {
        form.post(route('users.store'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                form.password = generateRandomPassword();
            },
        });
    }
};
</script>

<template>
    <section>
        <header>

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ props.user.id ? 'Editar Usuário' : 'Cadastro de Usuário' }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ props.user.id
                    ? 'Atualize as informações do usuário.'
                    : 'Preencha as informações para cadastrar um novo usuário.' }}
            </p>
        </header>

        <form @submit.prevent="saveUser" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Nome" />

                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                    autocomplete="name" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                    autocomplete="email" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Senha (Gerada automaticamente)" />

                <TextInput id="password" type="text" class="mt-1 block w-full" v-model="form.password" readonly />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div>
                <InputLabel for="role" value="Perfil" />

                <select id="role" v-model="form.role"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:focus:ring-gray-500"
                    required>
                    <option value="" disabled>Selecione um perfil</option>
                    <option v-for="role in roles" :key="role" :value="role">
                        {{ role }}
                    </option>
                </select>

                <InputError class="mt-2" :message="form.errors.role" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">
                    {{ props.user.id ? 'Salvar Alterações' : 'Cadastrar' }}
                </PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">
                        {{ props.user.id ? 'Usuário atualizado com sucesso.' : 'Usuário cadastrado com sucesso.' }}
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
