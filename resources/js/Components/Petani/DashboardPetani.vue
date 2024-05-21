<script setup>
import { Head, Link, usePage, useForm, router} from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import Swal from 'sweetalert2';
import { format } from "date-fns";
import PrimaryButton from '../PrimaryButton.vue';

const page = usePage()
const lahan = computed(() => page.props.datas);
console.log(page.props);
</script>

<template>
    <h2 class="text-lg font-medium text-gray-900 mb-3">Daftar Pekerjaan Anda</h2>
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
              <th scope="col" class="px-6 py-4">Alamat Lahan</th>
              <th scope="col" class="px-6 py-4">Nama Pemilik</th>
              <th scope="col" class="px-6 py-4">Nomor Telfon</th>
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
          <td class="whitespace-nowrap px-6 py-4 font-medium capitalize">{{ item.lahan.alamat_lahan }}</td>
          <td class="whitespace-nowrap px-6 py-4 font-medium capitalize">{{ item.pemilik.name }}</td>
          <td class="whitespace-nowrap px-6 py-4 font-medium capitalize">{{ item.pemilik.no_telfon }}</td>
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
            <Link :href="`/pekerjaan/${item.lahan.id}`" type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">Kelola Pekerjaan</Link>
          </td>
        </tr>
          </tbody>
          </table>
          </div>
          </div>
          </div>
          </div>
</template>