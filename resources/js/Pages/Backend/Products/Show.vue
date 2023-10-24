<template>
    <BackendLayout title="Products">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">{{ product.title }}</h1>
                    <p class="mt-2 text-sm text-gray-700">{{ product.subtitle }}</p>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <img :src="image_product" alt="">
                    </div>
                </div>
            </div>
        </div>
    </BackendLayout>
</template>
<script setup>

import { Link } from '@inertiajs/vue3'
import BackendLayout from '@/Layouts/BackendLayout.vue';

defineProps({
    product: Object,
    image_product: String,
});
</script>