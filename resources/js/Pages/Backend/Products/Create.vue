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
                        <div class="sm:w-1/2 ml-1">
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
                                <div class="relative mb-6">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                        <CurrencyDollarIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                    <input type="text" id="input-group-1"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm rounded-md pl-10 p-2.5 "
                                        placeholder="">
                                </div>
                                <InputError class="mt-2" :message="form.errors.price" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="photos" value="Photos" />
                                <input id="photos" type="file" class="mt-1 block w-full border-gray-300" required autofocus
                                    multiple autocomplete="username" @change="handleFileUpload">
                                <InputError class="mt-2" :message="form.errors.photos" />
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
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import BackendLayout from '@/Layouts/BackendLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { CurrencyDollarIcon } from '@heroicons/vue/20/solid';

defineProps({
    product: Object,
});

const form = useForm({
    title: '',
    subtitle: '',
    description: '',
    price: 0,
    photos: null,
});

const selectedFiles = ref();

const handleFileUpload = (event) => {
    const files = event.target.files;
    // Store the selected files in the selectedFiles array
    selectedFiles.value = Array.from(files);
};

const submitForm = async () => {
    const formData = new FormData();

    // Append the selected files to the FormData object
    for (const file of selectedFiles.value) {
        formData.append('photos[]', file);
    }

    // Append other form data to the FormData object
    formData.append('title', form.title);
    formData.append('subtitle', form.subtitle);
    formData.append('description', form.description);
    formData.append('price', form.price);

    try {
        // Make a POST request to your server using route.post
        await route.post('/admin/products', formData);

        // Handle the success response, e.g., redirect to a success page
        // or show a success message to the user
    } catch (error) {
        // Handle any errors, e.g., display an error message to the user
        console.error(error);
    }
};

</script>