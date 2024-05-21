<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { usePage, useForm  } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { ref } from 'vue';
import Swal from 'sweetalert2'
import { router } from '@inertiajs/vue3'
import LahanTable from '@/Components/Admin/LahanTable.vue'

const data = usePage().props;
const message = data.session.status;
let searchs = ref('')

const search = () => {
    const url = route('lahanpage.view', { search: searchs.value });
  router.visit(url);
};

if(message !== null){
    onMounted(() => {
        showToast()
    })
}

const showToast = () => {
  Swal.fire({
    icon: 'success',
    title: 'Sukses!',
    text: message,
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
};
</script>

<template>
 <Head title="Pemilik Lahan" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{data.header}}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Link
                        :href="'/register/pemilik_lahan'"
                        >
                        <button class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                            <i class="fa-solid fa-plus"></i> Tambah Pemilik Lahan
                        </button>
                        </Link>

                        <div class="max-w-md mt-8">   
                        <label for="default-search" class="mb-2 text-sm font-medium sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" v-model="searchs" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500  dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari data pemilik lahan" required />
                            <button @click="search" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cari</button>
                        </div>
                    </div>

                    <LahanTable
                    :lahan="data.lahan"/>
                        </div>
                    </div>
                </div>
            </div>
    </AuthenticatedLayout>
</template>