<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    id: Number,
})
</script>

<template>
    <Link :href="`/products/${id}/edit`" class="text-indigo-600 hover:text-indigo-500">Edit</Link>
</template>