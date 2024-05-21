<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import Swal from 'sweetalert2';
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const data = usePage().props
const diproses = ref(0)
const selesai = ref(0)
const message = data.session.status
const chartData = {
  labels: ['Pekerjaan Diproses', 'Pekerjaan Selesai'],
  datasets: [{
    label: 'Grafik Pekerjaan Lahan',
    data: [diproses.value = data.diproses, selesai.value = data.selesai],
    backgroundColor: [
      'rgb(168, 29, 42)',
      'rgb(54, 162, 235)',
    ],
    hoverOffset: 4
  }]
}

const chartOptions = {
  responsive: true
}
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

if(message !== null){
onMounted(() => {
  showToast();
});
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
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100"
    >
        
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold dark:text-gray-800 dark:text-gradient-to-bl hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-600 focus:outline focus:outline-2 focus:rounded-sm"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold dark:text-gray-800 dark:text-gradient-to-bl hover:text-gray-900 dark:text-gray-600 dark:hover:text-gray-600 focus:outline focus:outline-2 focus:rounded-sm"
                    >Log in</Link
                >
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <img src="https://i.ibb.co/W5dPcGR/pngtree-agriculture-wheat-template-vector-icon-design-natural-rice-farm-vector-png-image-38421048.png" alt="" class="w-40 h-40">
            </div>

            <h1 class="text-2xl font-extrabold text-center dark:text-gray-800 dark:text-gradient-to-bl">Kelompok Tani Desa Cinta Dame 4 Balimbingan</h1>
            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">

                    <div
                        href="https://laravel.com/docs"
                        class="scale-100 p-6 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex"
                    >
                        <div>
                            <h2 class="mb-3 mt-6 text-xl font-semibold text-gray-900 dark:text-white">Grafik Pekerjaan</h2>
                            <Bar
                            :width="500" :height="300"
                            id="my-chart-id"
                            :options="chartOptions"
                            :data="chartData"
                            />
                        </div>
                    </div>

                    <div
                        href="https://laravel.com/docs"
                        class="scale-100 p-6 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex"
                    >
                        <div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Informasi 
                            Kelompok Tani Desa Cinta Dame 4 Balimbingan</h2>
                            <h2 class="mt-6 text-md font-semibold text-gray-900 dark:text-white">Jumlah Petani: {{ data.petani }} Orang</h2>
                            <h2 class="mt-3 text-md font-semibold text-gray-900 dark:text-white">Jumlah Pekerjaan Lahan Diproses: {{ data.diproses }} Lahan</h2>
                            <h2 class="mt-3 text-md font-semibold text-gray-900 dark:text-white">Jumlah Pekerjaan Lahan Selesai: {{ data.selesai }} Lahan</h2>
                            <h2 class="mt-6 text-md font-semibold text-gray-900 dark:text-white">Total Lahan: {{ data.lahan }} Lahan</h2>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">
                <div class="text-center text-sm sm:text-start">&nbsp;</div>

                <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-end sm:ms-0">
               
                </div>
            </div>
        </div>
    </div>
</template>

<!-- <style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style> -->
