<template>
    <BackendLayout :title="`Edit Product: ${form.title}`">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Edit Product</h1>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <form @submit.prevent="submitForm">
                            <div class="sm:w-1/2 ml-1">
                                <!-- Your form fields for editing the product -->
                                <div class="">
                                    <InputLabel for="title" value="Title" />
                                    <TextInput id="title" v-model="form.title" type="text" class="mt-1 block w-full"
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
                                            v-model="form.price">
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.price" />
                                </div>
                                <div class="mt-4">
                                    <InputLabel for="images" value="Images" />
                                    <input id="images" type="file" class="mt-1 block w-full border-gray-300" autofocus
                                        ref="imageInput" @change="handleImageUpload" multiple>
                                    <InputError class="mt-2" :message="form.errors.images" />
                                    <InputLabel for="images" value="Current Images" />
                                    <div class="relative grid grid-cols-4 gap-4">
                                        <!-- Display the current images as thumbnails or links to remove them -->
                                        <div v-for="(image, index) in props.product.media" :key="index">
                                            <div class="relative">
                                                <button class="absolute" @click="removeCurrentImage(index)">
                                                    <XCircleIcon class="h-5 w-5 text-red-900" aria-hidden="true" />
                                                </button>
                                            </div>
                                            <img :src="image.original_url" alt="Current Image" class="w-full h-auto" />
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 ">
                                    <PrimaryButton class="ml-4 float-right" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        Update Product
                                    </PrimaryButton>
                                </div>
                            </div>
                        </form>
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
import { CurrencyDollarIcon, XCircleIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
    product: Object,
    user: Object,
});

// Initialize the form with product data for editing
const form = useForm({
    title: props.product.title,
    subtitle: props.product.subtitle,
    description: props.product.description,
    price: props.product.price,
    images: [], // Initialize images as an empty array
    user_id: props.product.user_id,
});

const imageInput = ref(null); // Initialize the imageInput ref

const handleImageUpload = () => {
    form.images = Array.from(imageInput.value.files); // Use form.images to store the selected images
};

// Method to remove a current image when the "Remove" button is clicked
const removeCurrentImage = (index) => {
    // You should remove the image from the form.images array, not the media array
    form.images.splice(index, 1);
};

const submitForm = () => {
    // Prepare the form data
    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('subtitle', form.subtitle);
    formData.append('description', form.description);
    formData.append('price', form.price);
    formData.append('user_id', form.user_id);

    form.images.forEach((image, index) => {
        formData.append(`images[${index}]`, image);
    });

    // Use Inertia to put the form data to your Laravel route for updating
    form.put(route('products.update', { product: props.product.slug }), formData);
};

</script>
