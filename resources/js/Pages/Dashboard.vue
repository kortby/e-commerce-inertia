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
                    <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-2">
                        <li class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow">
                            <div class="p-8">
                                <apexchart :width="chart.width" :height="chart.height" :type="chart.type"
                                    :options="chart.options" :series="chart.series"></apexchart>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </BackendLayout>
</template>

<script setup>
import BackendLayout from '@/Layouts/BackendLayout.vue';

defineProps({
    products: Object,
    chart: Object,
});
</script>