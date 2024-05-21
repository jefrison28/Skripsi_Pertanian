<script setup>
import { usePage, useForm, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue'
import { ref } from 'vue';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

const prop = defineProps({
    petani :{
        type:Object,
        default: () => ({})
    }
})

const data = prop.petani.data
const currentPage = usePage().props.petani.current_page
const prev_page = usePage().props.petani.prev_page_url
const next_page = usePage().props.petani.next_page_url
const disablePrev = ref(false)
const disableNext = ref(false)

if(prev_page == null){
    disablePrev.value = true
}

if(next_page == null){
    disableNext.value = true
}

const deleteItem = (id) => {
  Swal.fire({
  text: "Apakah yakin akan menghapus?",
  showCancelButton: true,
  confirmButtonText: "Yes",
}).then((result) => {
  if (result.isConfirmed) {
    router.delete(`/deletepetani/${id}`)
  }
});
}

console.log(data);
</script>

<template>
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
              <th scope="col" class="px-6 py-4">Nama Petani</th>
              <th scope="col" class="px-6 py-4">Jumlah Pekerjaan Lahan</th>
              <th scope="col" class="px-6 py-4">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b border-gray-400 dark:border-gray/10" v-if="data.length == 0">
            <td class="whitespace-nowrap text-center px-6 py-4 font-medium" colspan="5">Data Kosong</td>    
            </tr>

            <tr class="border-b border-gray-400 dark:border-gray/10" v-else v-for="(item, index) in data" :key="index">
              <td class="whitespace-nowrap px-6 py-4 font-medium">{{ index+1 }}</td>
              <td class="whitespace-nowrap px-6 py-4 capitalize">{{item.name}}</td>
              <td class="whitespace-nowrap px-6 py-4">
               <p v-if="item.pekerjaan == 0" class="text-rose-500">Tidak ada lahan</p>
               <p v-else>{{ item.pekerjaan }} Lahan</p>
            </td>
              <td class="whitespace-nowrap px-6 py-4">
            <div class="inline-flex rounded-md shadow-sm" role="group">
            <Link :href="`/dashboard/petani-page/view/${item.id}`" type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                <i class="far fa-eye"></i> 
               Lihat
            </Link>
            <Link :href="`/dashboard/petani-page/edit/${item.id}`" type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                <i class="fa-regular fa-pen-to-square"></i> 
               Edit
            </Link>
            <button type="button" @click="deleteItem(item.id)" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                <i class="fa-solid fa-trash"></i> 
                Hapus
            </button>
            </div>
            </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div v-if="data.length == 0"></div>
  <Pagination v-else
  :prev_link="prev_page"
  :next_link="next_page"
  :currentPage="currentPage"
  :disableNext="disableNext"
  :disablePrev="disablePrev"/>
</div>
</template>