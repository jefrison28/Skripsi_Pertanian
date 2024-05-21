<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const prop = defineProps({
    lahan :{
        type:Object,
        default: () => ({})
    }
});

const form = useForm({
    'id' : prop.lahan.id,
    'users_id' : prop.lahan.users.id
})

const confirmingHapus = ref(false)

const confirmHapus = () => {
    confirmingHapus.value = true
}

const closeModal = () => {
    confirmingHapus.value = false
}

const hapus = () => {
    form.delete(route('destroyLahan'))
};

</script>

<template>
   <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Hapus Lahan</h2>
            <p class="mt-1 text-sm text-gray-600 mb-3">
                Ketika lahan dihapus, semua data pekerjaan dan informasi lahan tidak bisa dikembalikan lagi.
             </p>
             <DangerButton @click="confirmHapus">Hapus</DangerButton>
            </header>
            <Modal :show="confirmingHapus" @close="closeModal">
                <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Apakah anda yakin akan menghapus?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Ketika lahan dihapus, semua data pekerjaan dan informasi lahan tidak bisa dikembalikan lagi.
                </p>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        @click="hapus"
                    >
                       Hapus Lahan
                    </DangerButton>
                </div>
              </div>
            </Modal>
    </section> 
</template>