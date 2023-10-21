<template>
    <BackendLayout title="Products">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Create new Product</h1>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <div class="sm:w-1/2">
                            <div class="">
                                <InputLabel for="title" value="Title" />
                                <TextInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" required
                                    autofocus autocomplete="username" />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>
                            <div class="mt-4 ">
                                <InputLabel for="subtitle" value="Subtitle" />
                                <TextInput id="subtitle" v-model="form.subtitle" type="text" class="mt-1 block w-full"
                                    required autofocus autocomplete="username" />
                                <InputError class="mt-2" :message="form.errors.subtitle" />
                            </div>
                            <div class="mt-4 ">
                                <InputLabel for="description" value="Description" />
                                <textarea
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    id="description" v-model="form.description" type="text" required autofocus
                                    autocomplete="username" />
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>
                            <div class="mt-4 w-32">
                                <InputLabel for="price" value="Price" />
                                $
                                <TextInput id="price" v-model="form.price" type="number" class="mt-1 block w-full" required
                                    autofocus autocomplete="username" />
                                <InputError class="mt-2" :message="form.errors.price" />
                            </div>
                            <div class="mt-4 ">
                                <PrimaryButton class="ml-4 float-right" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Create product
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </BackendLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import BackendLayout from '@/Layouts/BackendLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    product: Object,
});

const form = useForm({
    title: '',
    subtitle: '',
    description: '',
    price: 0,
});

</script>