<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import Loading from '@/Components/Loading.vue';
import Swal from 'sweetalert2';
import { onMounted } from 'vue';
import DashboardAdmin from '@/Components/Admin/DashboardAdmin.vue'
import DashboardPetani from '@/Components/Petani/DashboardPetani.vue';
import DashboardPemilikLahan from '@/Components/Lahan/DashboardPemilikLahan.vue';

const thisPage = usePage().props.datas;
const Page = usePage().props;
const user = usePage().props.auth.user.role
let isLoading = true;
if(thisPage){
    isLoading=false;
}
const message = Page.session.status
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

console.log(user)
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <Loading v-if="isLoading"/>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                    <div v-if="user == 'admin'">
                    <DashboardAdmin/>
                    </div>

                    <div v-if="user == 'petani'">
                    <DashboardPetani/>
                    </div>

                    <div v-if="user == 'pemilik_lahan'">
                    <DashboardPemilikLahan/>
                    </div>
                    </div>
                </div>
            </div>
            </div>
    </AuthenticatedLayout>
</template>
