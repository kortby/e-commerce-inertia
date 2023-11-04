<template>
    <FrontendLayout :itemsCartCount="props.products?.length">
        <div class="bg-white">
            <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Shopping Cart</h1>
                <form class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
                    <section aria-labelledby="cart-heading" class="lg:col-span-7">
                        <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

                        <ul role="list" class="divide-y divide-gray-200 border-b border-t border-gray-200">
                            <li v-for="(cartItem, cartItemIdx) in cartItems" :key="cartItem.id" class="flex py-6 sm:py-10">
                                <div class="flex-shrink-0 w-24">
                                    <img :src="getProductByCartItem(cartItem).media[0]?.original_url"
                                        :alt="getProductByCartItem(cartItem).title"
                                        class="w-24 rounded-md object-cover object-center sm:h-48 sm:w-48" />
                                </div>

                                <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                                    <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                        <div>
                                            <div class="flex justify-between">
                                                <h3 class="text-sm">
                                                    <a :href="getProductByCartItem(cartItem).href"
                                                        class="font-medium text-gray-700 hover:text-gray-800">{{
                                                            getProductByCartItem(cartItem).title }}</a>
                                                </h3>
                                            </div>
                                            <!-- <div class="mt-1 flex text-sm">
                                                <p class="text-gray-500">{{ product.color }}</p>
                                                <p v-if="product.size"
                                                    class="ml-4 border-l border-gray-200 pl-4 text-gray-500">{{ product.size
                                                    }}</p>
                                            </div> -->
                                            <p class="mt-1 text-sm font-medium text-gray-900">{{
                                                getProductByCartItem(cartItem).price }}</p>
                                        </div>

                                        <div class="mt-4 sm:mt-0 sm:pr-9">
                                            <label :for="`quantity-${cartItemIdx}`" class="sr-only">Quantity, {{
                                                getProductByCartItem(cartItem).title }}</label>

                                            <input readonly :id="`quantity-${cartItemIdx}`"
                                                :name="`quantity-${cartItemIdx}`"
                                                class="block w-14 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                type="number" v-model="cartItem.quantity"
                                                @change="updateQuantity(getProductByCartItem(cartItem).slug, cartItem.quantity)" />

                                            <!-- " -->

                                            <div class="absolute right-0 top-0">
                                                <button type="button"
                                                    @click="removeItem(getProductByCartItem(cartItem).slug, index)"
                                                    class="-m-2 inline-flex p-2 text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Remove</span>
                                                    <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <p class="mt-4 flex space-x-2 text-sm text-gray-700">
                                        <CheckIcon v-if="product.inStock" class="h-5 w-5 flex-shrink-0 text-green-500"
                                            aria-hidden="true" />
                                        <ClockIcon v-else class="h-5 w-5 flex-shrink-0 text-gray-300" aria-hidden="true" />
                                        <span>{{ product.inStock ? 'In stock' : `Ships in ${product.leadTime}` }}</span>
                                        <span>in 2 days</span>
                                    </p> -->
                                </div>
                            </li>
                        </ul>
                    </section>

                    <!-- Order summary -->
                    <section aria-labelledby="summary-heading"
                        class="mt-16 rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
                        <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>

                        <dl class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">${{ total }}</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="flex items-center text-sm text-gray-600">
                                    <span>Shipping estimate</span>
                                    <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
                                        <span class="sr-only">Learn more about how shipping is calculated</span>
                                        <QuestionMarkCircleIcon class="h-5 w-5" aria-hidden="true" />
                                    </a>
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">$0.00</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="flex text-sm text-gray-600">
                                    <span>Tax estimate</span>
                                    <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
                                        <span class="sr-only">Learn more about how tax is calculated</span>
                                        <QuestionMarkCircleIcon class="h-5 w-5" aria-hidden="true" />
                                    </a>
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">$0.00</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-base font-medium text-gray-900">Order total</dt>
                                <dd class="text-base font-medium text-gray-900">${{ total }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6">
                            <button type="submit"
                                class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Checkout</button>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </FrontendLayout>
</template>

<script setup>

import FrontendLayout from '../../Layouts/FrontendLayout.vue';
import { router } from '@inertiajs/vue3';
import { CheckIcon, ClockIcon, QuestionMarkCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    cartItems: Object,
    products: Object,
    total: Number,
    count: Number,
});

const getProductByCartItem = (cartItem) => {
    // Find the product that matches the cartItem's product_id
    return props.products.find(product => product.id === cartItem.product_id);
}

const updateQuantity = (slug, quantity) => {
    router.post(route('cart.update-quantity', { product: slug }), {
        quantity: quantity,
    });
}

const removeItem = (slug, index) => {
    router.delete(route('cart.remove', { product: slug, index }));
}

</script>