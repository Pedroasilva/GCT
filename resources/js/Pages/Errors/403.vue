<script setup>
    import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="403" />
    <div class="error-page">
        <h1>403 - Forbidden</h1>
        <p>Desculpe, você não tem permissão para acessar esta página.</p>
        <a href="/dashboard">Ir para a página inicial</a>
    </div>
</template>

<style scoped>
.error-page {
    text-align: center;
    margin-top: 50px;
}

.error-page h1 {
    font-size: 3rem;
    color: #ff6b6b;
}

.error-page p {
    font-size: 1.2rem;
    margin: 20px 0;
}

.error-page a {
    color: #3498db;
    text-decoration: none;
    font-weight: bold;
}

.error-page a:hover {
    text-decoration: underline;
}
</style>
