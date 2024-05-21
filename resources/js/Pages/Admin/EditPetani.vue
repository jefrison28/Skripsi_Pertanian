<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import BackButton from '@/Components/BackButton.vue';

const data = usePage().props
const petani = useForm({
    name : data.petani.name,
    email : data.petani.email,
    no_telfon: data.petani.no_telfon,
    password : '',
    password_confirmation : '',
    id : data.petani.id,
    role: data.petani.role
});
const submit = () => {
    petani.post(route('updateUser'), {
        onFinish: () => petani.reset('password', 'password_confirmation'),
    });
};
console.log(petani);
</script>

<template>
    <Head title="Petani Page" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{data.header}}</h2>
            <BackButton/>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-lg font-medium text-gray-900">Informasi Data Petani</h2>
                        <div class="space-y-6">
                        <form @submit.prevent="submit">
                        <div class="mt-3">
                            <InputLabel for="name" value="Nama Petani" /> 
                                <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full capitalize"
                                autofocus
                                autocomplete="name"
                                v-model="petani.name"
                            />
                        </div>
                        
                        <div class="mt-3">
                            <InputLabel for="email" value="Email Petani" /> 
                                <TextInput
                                id="email"
                                type="text"
                                class="mt-1 block w-full capitalize text-gray-500"
                                readonly
                                autofocus
                                autocomplete="email"
                                v-model="petani.email"
                            />
                        </div>

                        <div class="mt-3">
                            <InputLabel for="no_telfon" value="No Telfon" /> 
                                <TextInput
                                id="no_telfon"
                                type="text"
                                class="mt-1 block w-full capitalize"
                                autofocus
                                autocomplete="no_telfon"
                                v-model="petani.no_telfon"
                            />
                            <InputError class="mt-2" :message="petani.errors.no_telfon" />
                        </div>

                        <div class="mt-3">
                            <InputLabel for="password" value="Password" /> 
                                <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block w-full capitalize"
                                autofocus
                                autocomplete="password"
                                v-model="petani.password"
                            />
                            <InputError class="mt-2" :message="petani.errors.password" />
                        </div>

                        <div class="mt-3">
                            <InputLabel for="password_confirmation" value="Konfirmasi Password" /> 
                                <TextInput
                                id="password_confirmation"
                                type="password"
                                class="mt-1 block w-full capitalize"
                                autofocus
                                autocomplete="password_confirmation"
                                v-model="petani.password_confirmation"
                            />
                            <InputError class="mt-2" :message="petani.errors.password_confirmation" />
                        </div>

                        <div class="mt-3">
                    <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                     >Simpan</button>
                        </div>
                    </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
    </AuthenticatedLayout>
    
</template>