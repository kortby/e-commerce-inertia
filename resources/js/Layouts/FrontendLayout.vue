<script setup>
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    title: String,
});

</script>

<template>
    <div>

        <Head :title="title" />

        <div class="min-h-screen bg-gray-100">
            <!-- nav -->

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
