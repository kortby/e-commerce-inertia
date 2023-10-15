<script setup>
import BackendLayout from '@/Layouts/BackendLayout.vue';
</script>

<template>
    <BackendLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <h1>Welcome to your E-commerce application!</h1>
                </div>
            </div>
        </div>
    </BackendLayout>
</template>
