<script setup>
import { Head, Link, usePage, useForm, router} from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import Swal from 'sweetalert2';
import { format } from "date-fns";

const page = usePage()
const lahan = computed(() => page.props.datas)
const approve = (id) => {
  router.post(`approvePekerjaan/${id}`)
  showToast();
};

const showToast = () => {
  Swal.fire({
    icon: 'success',
    title: 'Sukses!',
    text: 'Approve berhasil',
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
};
</script>

<template>
    <div class="max-w-md mt-8">   
         <label for="default-search" class="mb-2 text-sm font-medium sr-only">Search</label>
               <div class="relative">
                   <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                      <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                             <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                             </svg>
                            </div>
                        <input type="text" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500  dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari data lahan" required />
                        <button class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cari</button>
                </div>
            </div>

<div class="flex flex-col mt-8">
  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
      <div class="overflow-hidden">
        <table
          class="min-w-full text-left text-sm font-light text-surface dark:text-black">
          <thead
            class="border-b border-neutral-200 font-medium dark:border-gray/10">
            <tr>
              <th scope="col" class="px-6 py-4">#</th>
              <th scope="col" class="px-6 py-4">Nama Lahan</th>
              <th scope="col" class="px-6 py-4">Nama Pemilik</th>
              <th scope="col" class="px-6 py-4">Progress</th>
              <th scope="col" class="px-6 py-4">Status</th>
              <th scope="col" class="px-6 py-4">Action</th>
            </tr>
          </thead>
          <tbody>
        <tr class="border-b border-gray-400 dark:border-gray/10" v-if="lahan.length == 0">
          <td class="whitespace-nowrap text-center px-6 py-4 font-medium" colspan="6">Data Kosong</td>    
        </tr>

        <tr class="border-b border-gray-400 dark:border-gray/10" v-else v-for="(item, index) in lahan" :key="index">
          <td class="whitespace-nowrap px-6 py-4 font-medium">{{ index+1 }}</td>
          <td class="whitespace-nowrap px-6 py-4 font-medium capitalize">{{ item.lahan.namalahan }}</td>
          <td class="whitespace-nowrap px-6 py-4 font-medium capitalize">{{ item.pemilik.name }}</td>

          <td class="whitespace-nowrap px-6 py-4 font-medium capitalize">
            <p class="mb-1 text-base font-small dark:text-dark">{{ item.persentasePekerjaan }}%</p>
          <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-700">
            <div class="bg-blue-600 h-1.5 rounded-full dark:bg-blue-500" :style="{ width: item.persentasePekerjaan + '%' }"></div>
          </div>
          </td>

          <td class="whitespace-nowrap px-6 py-4 font-medium capitalize">
            <p v-if="item.lahan.status == 0" class="text-rose-500">Lahan sedang diproses</p>
            <p v-else-if="item.lahan.status == 1">Pekerjaan selesai pada {{format(new Date(item.lahan.pekerjaan_selesai), "dd/MM/yyyy")}}</p>
          </td>

          <td class="whitespace-nowrap px-6 py-4 font-medium capitalize">
            <div class="inline-flex rounded-md shadow-sm" role="group">
              <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white"
              :class="{ 'opacity-50': item.persentasePekerjaan < 100 || item.lahan.status == 1 }"
              :disabled="item.persentasePekerjaan < 100 || item.lahan.status == 1" @click="approve(item.lahan.id)">
              <i class="fa-solid fa-check"></i>
            Approve
            </button>

            <Link :href="`/maps/${item.lahan.id}`"  type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
              <i class="fa-solid fa-map"></i>
               Lihat Maps
            </Link>
            <Link :href="`/dashboard/lahan-page/manage/lahan/${item.lahan.id}`" type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
              <i class="fas fa-tasks"></i>
               Kelola
            </Link>
            </div>
          </td>
        </tr>
          </tbody>
          </table>
          </div>
          </div>
          </div>
          </div>
</template>