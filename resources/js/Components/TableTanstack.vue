<script setup>
import { ref, watchEffect } from 'vue'
import {
    useVueTable,
    FlexRender,
    getCoreRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    getFilteredRowModel,
} from '@tanstack/vue-table'
import { ChevronLeftIcon, ChevronRightIcon, ChevronDoubleRightIcon, ChevronDoubleLeftIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    data: Array,
    columns: Array,
})

const data = ref(props.data)

const sorting = ref([])
const filter = ref('')
const selectedPageSize = ref('10'); // Default page size

const table = useVueTable({
    data: data.value,
    columns: props.columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    state: {
        get sorting() {
            return sorting.value
        },
        get globalFilter() {
            return filter.value
        },
    },
    onSortingChange: updaterOrValue => {
        sorting.value =
            typeof updaterOrValue === 'function'
                ? updaterOrValue(sorting.value)
                : updaterOrValue
    },
    // initialState: {
    //   pagination: {
    //     pageSize: 10,
    //   },
    // },
})

// Watch for changes in selectedPageSize
watchEffect(() => {
    table.setPageSize(parseInt(selectedPageSize.value));
});

</script>

<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="my-4 flex">
                        <div>
                            <input type="text" class="border border-gray-400 rounded px-2 py-2" placeholder="Search"
                                v-model="filter" />
                        </div>
                        <div class="flex-auto">
                        </div>
                        <div class="flex-auto w-12">
                            <div class="mt-2 text-right">
                                <select id="page-size" name="page-size" autocomplete="page-size"
                                    class="block float-right rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    v-model="selectedPageSize">
                                    <option value="5">Page Size 5</option>
                                    <option value="10">Page Size 10</option>
                                    <option value="20">Page Size 20</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                                    <th v-for="header in headerGroup.headers" :key="header.id" scope="col"
                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900" :class="{
                                            'cursor-pointer select-none': header.column.getCanSort(),
                                        }" @click="header.column.getToggleSortingHandler()?.($event)">
                                        <FlexRender :render="header.column.columnDef.header" :props="header.getContext()" />
                                        {{ { asc: ' ↑', desc: '↓' }[header.column.getIsSorted()] }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                <tr v-for="row in table.getRowModel().rows" :key="row.id">
                                    <td v-for="cell in row.getVisibleCells()" :key="cell.id"
                                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-8">
                <nav class="flex items-center justify-between bg-white px-4 sm:px-6" aria-label="Pagination">
                    <div class="hidden sm:block">
                        <p class="text-sm text-gray-700">
                            Showing
                            {{ ' ' }}
                            <span class="font-medium">{{ table.getState().pagination.pageIndex + 1 }}</span>
                            {{ ' ' }}
                            to
                            {{ ' ' }}
                            <span class="font-medium">{{ table.getPageCount() }}</span>
                            {{ ' ' }}
                            of
                            {{ ' ' }}
                            <span class="font-medium">{{ table.getFilteredRowModel().rows.length }}</span>
                            {{ ' ' }}
                            results
                        </p>
                    </div>
                    <div class="flex flex-1 justify-between sm:justify-end">
                        <button
                            class="relative inline-flex items-center rounded-md bg-white px-3 py-2 mr-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0"
                            @click="table.setPageIndex(0)">
                            <ChevronDoubleLeftIcon class="h-5 w-5" aria-hidden="true" /> First
                        </button>
                        <button
                            class="relative inline-flex items-center rounded-md bg-white px-3 py-2 mr-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0"
                            :disabled="!table.getCanPreviousPage()" @click="table.previousPage()">
                            <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" /> Prev
                        </button>
                        <button
                            class="relative inline-flex items-center rounded-md bg-white px-3 py-2 mr-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0"
                            :disabled="!table.getCanNextPage()" @click="table.nextPage()">
                            Next
                            <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                        </button>
                        <button
                            class="relative inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:outline-offset-0"
                            @click="table.setPageIndex(table.getPageCount() - 1)">
                            Last
                            <ChevronDoubleRightIcon class="h-5 w-5" aria-hidden="true" />
                        </button>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</template>