<template>
    <FrontendLayout :itemsCartCount="count">
        <div class="bg-white">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                <h2 class="text-xl font-bold text-gray-900">Customers also bought</h2>

                <div class="mt-8 grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                    <div v-for="product in products" :key="product.id">
                        <div class="relative">
                            <div class="relative h-72 w-full overflow-hidden rounded-lg">
                                <img :src="product.media[0]?.original_url" :alt="product.title"
                                    class="h-full w-full object-cover object-center" />
                            </div>
                            <div class="relative mt-4">
                                <h3 class="text-sm font-medium text-gray-900">{{ product.title }}</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ product.color }}</p>
                            </div>
                            <div
                                class="absolute inset-x-0 top-0 flex h-72 items-end justify-end overflow-hidden rounded-lg p-4">
                                <div aria-hidden="true"
                                    class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50" />
                                <p class="relative text-lg font-semibold text-white">${{ product.price }}</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a :href="product.href" @click="addToCart(product)"
                                class="relative flex items-center justify-center rounded-md border border-transparent bg-gray-100 px-8 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200">Add
                                to Cart<span class="sr-only">, {{ product.title }}</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </FrontendLayout>
</template>

<script setup>
import FrontendLayout from '../../Layouts/FrontendLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue'

defineProps({
    products: Object,
    count: Number,
});


const addToCart = (product) => {
    router.post(route('cart.add', { product: product.slug }), {
        quantity: 1,
    });
}
</script>