<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { format } from "date-fns";
import  axios  from 'axios';
import { ref } from 'vue'
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import BackButton from '@/Components/BackButton.vue';

const data = usePage().props
const petani = useForm({
    name : data.petani.name,
    email : data.petani.email,
    no_telfon: data.petani.no_telfon
});

const pekerjaan = ref('')
const lahan = ref('')
const showDetail = ref(false)
const lookDetail = (id) => {
    showDetail.value = true
    axios.get(`/api/pekerjaan-petani/${id}`).then(
        response => {
           pekerjaan.value = response.data.pekerjaan
           lahan.value = response.data.lahan
        }
    )
}
const closeDetail = () => {
    showDetail.value = false
}
console.log(data);
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
                        <div class="space-y-6">
                            <!-- {{ pekerjaan }} -->
                            <div>
                                <InputLabel for="name" value="Nama Petani" /> 
                                <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full capitalize text-gray-500"
                                readonly
                                autofocus
                                autocomplete="name"
                                v-model="petani.name"
                            />
                            </div>

                            <div>
                                <InputLabel for="name" value="Email" /> 
                                <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full capitalize text-gray-500"
                                readonly
                                autofocus
                                autocomplete="name"
                                v-model="petani.email"
                            /> 
                            </div>

                            <div>
                                <InputLabel for="no_telfon" value="No Telfon" /> 
                                <TextInput
                                id="no_telfon"
                                type="text"
                                class="mt-1 block w-full capitalize text-gray-500"
                                readonly
                                autofocus
                                autocomplete="no_telfon"
                                v-model="petani.no_telfon"
                            /> 
                            </div>
                            
                        </div>
                        <hr class="mt-6"/>
                        <h2 class="font-semibold text-md mt-5 text-gray-800 leading-tight">Data pekerjaan lahan</h2>
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8 mt-4">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                        <table
                        class="min-w-full text-left text-sm font-light text-surface dark:text-black">
                        <thead
                            class="border-b border-neutral-200 font-medium dark:border-gray/10">
                            <tr>
                            <th scope="col" class="px-6 py-4">#</th>
                            <th scope="col" class="px-6 py-4">Nama Lahan</th>
                            <th scope="col" class="px-6 py-4">Alamat Lahan</th>
                            <th scope="col" class="px-6 py-4">Status Pekerjaan</th>
                            <th scope="col" class="px-6 py-4">Detail Pekerjaan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr class="border-b border-gray-400 dark:border-gray/10" v-if="data.pekerjaan_lahan.length == 0">
                        <td class="whitespace-nowrap text-center px-6 py-4 font-medium" colspan="5">Data pekerjaan Kosong</td>    
                        </tr>
                        <tr v-else class="border-b border-gray-400 dark:border-gray/10" v-for="(item, index) in data.pekerjaan_lahan" :key="index">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">{{ index+1 }}</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium capitalize">{{ item.lahan.namalahan }}</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium capitalize">{{ item.lahan.alamat_lahan }}</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium capitalize">
                            <p v-if="item.lahan.status == 0" class="text-rose-500">Lahan sedang diproses</p>
                            <p v-else-if="item.lahan.status == 1">Pekerjaan selesai pada {{format(new Date(item.lahan.pekerjaan_selesai), "dd/MM/yyyy")}}</p>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium capitalize">
                        <button @click="lookDetail(item.lahan.id)" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white"><i class="fa-solid fa-circle-info"></i> Lihat</button>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                        </div>
                        </div>

                    <Modal :show="showDetail" @close="closeDetail">
                        <div class="p-6">
                            <h2 class="text-lg capitalize font-medium text-gray-900">
                                {{lahan.namalahan}}
                            </h2>
                            <p class="mt-3 capitalize">Alamat: {{ lahan.alamat_lahan }}</p>
                            <p class="mt-1">Luas lahan: {{ lahan.luas_lahan }} m&sup2;</p>
                            <div class="block mt-6">
                            <label class="flex items-center" v-for="(item, index) in pekerjaan">
                                <Checkbox :checked="item.status == 1 == true" disabled />
                                <span class="ms-2 text-sm text-gray-600" v-if="item.status == 1">{{item.deskripsi}} - {{format(new Date(item.pekerjaan_selesai), "dd/MM/yyyy")}}</span>
                                <span class="ms-2 text-sm text-gray-600" v-else>{{item.deskripsi}}</span>
                            </label>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <SecondaryButton @click="closeDetail"> Close </SecondaryButton>
                            </div>
                            </div>
                    </Modal>

                    </div>
                        </div>
                    </div>
                </div>
    </AuthenticatedLayout>
</template>