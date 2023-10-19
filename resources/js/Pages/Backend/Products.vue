<template>
    <BackendLayout title="Products">
        <div class="py-12">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Product</h1>
                        <p class="mt-2 text-sm text-gray-700">A list of all the products in your account including their
                            title,
                            price and role.</p>
                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <button type="button"
                            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add
                            Product</button>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle">
                            <TableTanstack :data="products" :columns="columnsProducts" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </BackendLayout>
</template>

<script setup>
import BackendLayout from '@/Layouts/BackendLayout.vue';
import moment from 'moment';
import TableTanstack from '@/Components/TableTanstack.vue';

defineProps({
    products: Object,
    chart: Object,
});

const columnsProducts = [
    {
        accessorKey: 'id',
        header: 'ID',
        enableSorting: false,
    },
    {
        accessorKey: 'title',
        header: 'Title',
    },
    {
        accessorKey: 'slug',
        header: 'Slug',
    },
    {
        accessorKey: 'created_at',
        header: 'Created',
        cell: info => moment(info.getValue()).format('MMMM Do YYYY'),
    },
    {
        accessorKey: 'price',
        header: 'Price',
        cell: info => `$${info.getValue()}`,
    },
]

</script>