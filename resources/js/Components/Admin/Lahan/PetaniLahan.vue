<script setup>
import { usePage, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, computed } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { format } from "date-fns";
import DangerButton from '@/Components/DangerButton.vue';

const data = usePage().props;
const lahan = data.lahan;
const users = data.auth.user.role;
const petani = data.listpetani
const isEdit = ref(false)
const idToDelete = ref(null);
const modalAdd = ref(false)
const modalEdit = ref(false)
const modalDelete = ref(false)
const selectedIndex = ref(null);
const selectedPetani = ref(null)
const prop = defineProps({
    petani :{
        type:Array,
        default: () => ({})
    }
});

const form = useForm({
    'id' : '',
    'users_id' : '',
    'lahan_id' : data.lahan.id
});

const openModalDelete = (id) => {
    modalDelete.value = true
    idToDelete.value = id;
}

const closeModalDelete = () => {
    modalDelete.value = false
}


const openModalAdd = () => {
    modalAdd.value = true
}

const closeModalAdd = () => {
    modalAdd.value = false
}

const addPetani = () => {
    form.post(route('addPetani'),{
        preserveScroll: true,
        onSuccess: () =>  closeModalAdd(),
        onFinish: () => window.location.reload(),
    })
}

const deletePetani = () => {
    form.id = idToDelete.value;
    form.delete(route('deletePetaniLahan'),{
        preserveScroll: true,
        onSuccess: () =>  closeModalDelete(),
        onFinish: () => window.location.reload(),
    })
}

const formpetani = useForm({
    'id' : data.petani.map(item => item.id),
    'users_id' : data.petani.map(item => item.users_id),
    'name' : data.petani.map(item => item.users.name),
    'no_telfon' : data.petani.map(item => item.users.no_telfon)
});
</script>

<template>
   <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Daftar Petani</h2>
            <div v-if="users == 'admin'">
            <SecondaryButton :class="{'opacity-65' : lahan.status == true}" :disabled="lahan.status == true" class="mt-3 mb-2" @click="openModalAdd">Tambah Petani</SecondaryButton>
            </div>
            <div class="mt-3">
                 <InputLabel for="daftarpetani" value="Daftar Petani Yang Mengerjakan" />
                 <div v-for="(item, index) in formpetani.users_id && formpetani.id" :key="index" class="mt-3 overflow-hidden">
                    <table  class="min-w-full text-left text-sm font-light text-surface dark:text-black">
                    <tbody>
                        <tr>
                        <td class="whitespace-nowrap font-medium" v-if="users == 'admin'">
                        <TextInput
                        id="deskripsipekerjaan"
                        type="text"
                        class="mt-1 block w-full capitalize"
                        autofocus
                        v-model="formpetani.name[index]"
                        :disabled="isEdit == false"
                        :class="{'opacity-50' : isEdit == false}"
                    />
                        </td>
                        <td class="whitespace-nowrap font-medium" v-if="users == 'pemilik_lahan' || users == 'petani'">
                        <p class="capitalize text-md">{{ index+1 }}. {{ formpetani.name[index] }} - {{ formpetani.no_telfon[index] }} (No Telfon)</p>
                        </td>
                        <td class="whitespace-nowrap font-medium" v-if="users == 'admin'">
                    <!-- <PrimaryButton class="ml-2" @click="openModalEdit(formpetani.id[index],formpetani.users_id[index])"><i class="far fa-edit"></i> Edit</PrimaryButton> -->
                    <DangerButton :class="{'opacity-65' : lahan.status == true}" :disabled="lahan.status == true" class="ml-2" @click="openModalDelete(formpetani.id[index])"><i class="fa-solid fa-trash"></i> Hapus</DangerButton>
                    </td>
                    </tr>
                    </tbody>
                </table>
                </div>

                <Modal :show="modalAdd" @close="closeModalAdd">
                <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Tambah Petani
                </h2>
                <select class="mt-3 block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 capitalize" v-model="form.users_id">
                <option v-if="petani.length > 0" :value="null" :selected="form.users_id == null">Pilih Petani</option>
                <option v-for="(petaniItem, petaniIndex) in petani" :key="petaniIndex" :value="petaniItem.id" :disabled="petaniItem.jumlah_pekerjaan >= 3">{{ petaniItem.name }} {{ petaniItem.jumlah_pekerjaan >= 3 ? '(jumlah maksimum pekerjaan lahan sudah melebihi batas)' : '' }}</option>
                </select>
                <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModalAdd"> Cancel </SecondaryButton>
                <PrimaryButton @click="addPetani"
                    class="ms-3">Save</PrimaryButton>
                </div>
                </div>
                </Modal>

                <Modal :show="modalDelete" @close="closeModalDelete">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Apakah anda yakin akan menghapus?
                </h2>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModalDelete"> Cancel </SecondaryButton>
                    <DangerButton
                        class="ms-3"
                        @click="deletePetani"
                    >
                       Hapus Petani
                    </DangerButton>
                </div>
              </div>
        </Modal>
                </div>
        </header>
    </section>
</template>