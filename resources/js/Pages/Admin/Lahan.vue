<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import InformasiLahan from '@/Components/Admin/Lahan/InformasiLahan.vue';
import PekerjaanLahan from '@/Components/Admin/Lahan/PekerjaanLahan.vue';
import PetaniLahan from '@/Components/Admin/Lahan/PetaniLahan.vue'
import DeleteLahan from '@/Components/Admin/Lahan/DeleteLahan.vue'
import BackButton from '@/Components/BackButton.vue'


const prop = usePage().props;
const data = defineProps({
    lahan :{
        type:Object,
        default: () => ({})
    },
    pekerjaan :{
        type:Object,
        default: () => ({})
    },
    petani :{
        type:Object,
        default: () => ({})
    }
});

</script>

<template>
<Head title="Kelola Lahan" />
<AuthenticatedLayout>
    <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">Lahan {{ prop.lahan.namalahan }}</h2>
            <BackButton/>
    </template>
        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <InformasiLahan
        :lahan="data.lahan"/>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <PekerjaanLahan
            :pekerjaan="data.pekerjaan"/>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <PetaniLahan
            :petani="data.petani"/>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <DeleteLahan
            :lahan="data.lahan"/>
        </div>

        </div>
        </div>
</AuthenticatedLayout>
</template>