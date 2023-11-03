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
                        <form @submit.prevent="submitForm">
                            <div class="sm:w-1/2 ml-1">
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
                                        <input type="number" id="input-group-1"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm rounded-md pl-10 p-2.5 "
                                            placeholder="" v-model="form.price">
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.price" />
                                </div>
                                <div class="mt-4">
                                    <InputLabel for="photos" value="Images" />
                                    <input id="images" type="file" class="mt-1 block w-full border-gray-300" required
                                        autofocus ref="imageInput" @change="handleImageUpload" multiple>
                                    <InputError class="mt-2" :message="form.errors.images" />
                                </div>
                                <div class="mt-4 ">
                                    <PrimaryButton class="ml-4 float-right" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        Create product
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
import { CurrencyDollarIcon } from '@heroicons/vue/20/solid';


const props = defineProps({
    user: Object,
});

const form = useForm({
    title: '',
    subtitle: '',
    description: '',
    price: 0,
    images: [],
    user_id: props.user.id,
});

const imageInput = ref(null);

const handleImageUpload = () => {
    form.images = Array.from(imageInput.value.files);
};


const submitForm = () => {
    // Prepare the form data
    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('subtitle', form.subtitle);
    formData.append('description', form.description);
    formData.append('price', form.price);
    formData.append('user_id', form.user_id);

    // Append each selected image file to the FormData.
    form.images.forEach((image, index) => {
        formData.append(`images[${index}]`, image);
    });

    console.log(form)
    // Use Inertia to post the form data to your Laravel route
    // Replace 'admin.products.store' with your actual route name
    form.post(route('products.store'))
};

</script>