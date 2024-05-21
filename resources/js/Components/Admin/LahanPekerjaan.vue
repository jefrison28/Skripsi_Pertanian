<script setup>
import { usePage, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const prop = defineProps({
    lahan :{
        type:Object,
        default: () => ({})
    }
});
const user = usePage().props.auth.user
console.log('ini propnya', user)
</script>

<template>
    <div class="flex flex-col mt-8">
  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
      <div class="overflow-hidden">
        <table
          class="min-w-full text-center text-sm font-light text-surface dark:text-black">
          <thead
            class="border-b border-neutral-200 font-medium dark:border-gray/10">
            <tr>
              <th scope="col" class="px-6 py-4">#</th>
              <th scope="col" class="px-6 py-4">Nama Lahan</th>
              <th scope="col" class="px-6 py-4">Alamat Lahan</th>
              <th scope="col" class="px-6 py-4">Luas Lahan</th>
              <th scope="col" class="px-6 py-4">Progress Pekerjaan</th>
              <th scope="col" class="px-6 py-4">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b border-gray-400 dark:border-gray/10" v-if="lahan.length == 0">
            <td class="whitespace-nowrap text-center px-6 py-4 font-medium" colspan="6">Data Kosong</td>    
            </tr>
            <tr v-else class="border-b border-gray-400 dark:border-gray/10" v-for="(item, index) in lahan">
            <td class="whitespace-nowrap text-center px-6 py-4 font-medium">{{ index+1 }}</td>
            <td class="whitespace-nowrap text-center px-6 py-4 font-medium capitalize">{{ item.lahan.namalahan }}</td>
            <td class="whitespace-nowrap text-center px-6 py-4 font-medium capitalize">{{ item.lahan.alamat_lahan }}</td>
            <td class="whitespace-nowrap text-center px-6 py-4 font-medium">{{ item.lahan.luas_lahan }} m&sup2;</td>
            <td class="whitespace-nowrap text-center px-6 py-4 font-medium">
            <p class="mb-1 text-base font-small dark:text-dark">{{ item.persentasePekerjaan }}%</p>
            <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-700">
            <div class="bg-blue-600 h-1.5 rounded-full dark:bg-blue-500" :style="{ width: item.persentasePekerjaan + '%' }"></div>
            </div>
            </td>
            <td v-if="user.role == 'admin'" class="whitespace-nowrap text-center px-6 py-4 font-medium">
                <div class="inline-flex rounded-md shadow-sm" role="group">
            <Link :href="`/maps/${item.lahan.id}`" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                <i class="fa-solid fa-map"></i>
               Lihat Maps
            </Link>
            <Link :href="`/dashboard/lahan-page/manage/lahan/${item.lahan.id}`" type="button" @click="deleteItem(item.id)" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
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