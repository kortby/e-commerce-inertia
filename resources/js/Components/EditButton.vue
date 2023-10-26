<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    slug: String,
})
</script>

<template>
    <Link :href="`products/${slug}/edit`" class="text-indigo-600 hover:text-indigo-500">Edit</Link>
</template>