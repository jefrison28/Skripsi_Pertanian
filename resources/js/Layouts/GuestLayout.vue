<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <Link href="/">
                <!-- <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" /> -->
                <img src="https://i.ibb.co/W5dPcGR/pngtree-agriculture-wheat-template-vector-icon-design-natural-rice-farm-vector-png-image-38421048.png" alt="" class="w-40 h-40">
            </Link>
        </div>
       <center><p class="text-xl font-semibold">Kelompok Tani Desa Cinta Dame 4 Balimbingan</p></center>
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
