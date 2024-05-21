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
import Checkbox from '@/Components/Checkbox.vue';
import { router } from '@inertiajs/vue3';

const isEdit = ref(false)
const modalAdd = ref(false)
const modalEdit = ref(false)
const modalDelete = ref(false)
const selectedIndex = ref(null);
const selectedDeskripsi = ref(null)
const idToDelete = ref(null)

const data = usePage().props
const prop = defineProps({
    pekerjaan :{
        type:Array,
        default: () => ({})
    }
});

const form = useForm({
    'id' : '',
    'deskripsi' : '',
    'lahan_id' : data.lahan.id,
    'check' : null
})

const openModalDelete = (id) => {
    modalDelete.value = true
    idToDelete.value = id;
}

const closeModalDelete = () => {
    modalDelete.value = false
}

const deletePekerjaan = () => {
form.id = idToDelete.value;
form.delete(route('hapusPekerjaan'))
closeModalDelete()
window.location.reload();
}

const openModalEdit = (id,deskripsi) => { 
    modalEdit.value = true
    form.id = id
    form.deskripsi = deskripsi
}

const closeModalEdit = () => {
    modalEdit.value = false
}

const openModalAdd = () => {
    modalAdd.value = true
}

const closeModalAdd = () => {
    modalAdd.value = false
}

const addPekerjaan = () => {
    form.post(route('addPekerjaan'),{
        preserveScroll: true,
        onSuccess: () =>  closeModalAdd(),
        onFinish: () => window.location.reload(),
    })
}

const editPekerjaan = () => {
    form.put(route('updatePekerjaan'),{
        preserveScroll: true,
        onSuccess: () =>  closeModalEdit(),
        onFinish: () => window.location.reload(),
    })
}

const check = (index) => {
    formpekerjaan.status[index] = !formpekerjaan.status[index];
    form.check = formpekerjaan.status[index]
    form.id = formpekerjaan.id[index]
    form.post(route('checkPekerjaan'),{
        preserveScroll: true,
    })
}

const formpekerjaan = useForm({
    'id' : data.pekerjaan.map(item => item.id),
    'deskripsi' : data.pekerjaan.map(item => item.deskripsi),
    'pekerjaan_selesai' : data.pekerjaan.map(item => item.pekerjaan_selesai),
    'status' : data.pekerjaan.map(item => item.status),
    'created_at' : data.pekerjaan.map(item => item.created_at),
    'status' :  data.pekerjaan.map(item => item.status),
});
const lahan = data.lahan;
const users = data.auth.user.role;
</script>

<template>
      <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Daftar Pekerjaan Lahan</h2>
            <div v-if="users == 'admin' && lahan.status == false">
                <SecondaryButton class="mt-3 mb-2" @click="openModalAdd" v-if="users == 'admin'"
                :class="{'opacity-65' : lahan.status == true}" :disabled="lahan.status == true">Tambah Pekerjaan</SecondaryButton>
            </div>
            <div class="mt-3">
                 <InputLabel for="deskripsipekerjaan" value="Deskripsi Pekerjaan" />
                 <p class="text-sm text-gray-900 mt-2" v-if="users == 'petani'">Checklist tiap pekerjaan dibawah ini yang sudah selesai dikerjakan.</p>
                 <div v-for="(item, index) in formpekerjaan.deskripsi && formpekerjaan.id" :key="index" class="mt-3 overflow-hidden">
                   <table  class="min-w-full text-left text-sm font-light text-surface dark:text-black">
                    <thead v-if="users == 'petani'"
                    class="border-b border-neutral-100 font-medium dark:border-gray/10">
                    <tr>
                        <th scope="col" class="px-1 py-1">Pekerjaan</th>
                        <th scope="col" class="px-1 py-1">Checklist</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td class="whitespace-nowrap font-medium">
                    <TextInput
                        id="deskripsipekerjaan"
                        type="text"
                        class="mt-1 block w-full capitalize"
                        autofocus
                        autocomplete="deskripsipekerjaan"
                        placeholder="Masukan deskripsi pekerjaan"
                        v-model="formpekerjaan.deskripsi[index]"
                        :disabled="isEdit == false"
                        :class="{'opacity-50' : isEdit == false}"
                    />
                </td>
                <td class="whitespace-nowrap font-medium" v-if="users == 'admin'">
                    <PrimaryButton class="ml-2" @click="openModalEdit(formpekerjaan.id[index],formpekerjaan.deskripsi[index])"  :class="{'opacity-65' : formpekerjaan.status[index] == true}" :disabled="formpekerjaan.status[index] == true"><i class="far fa-edit"></i> Edit</PrimaryButton>
                    <DangerButton class="ml-2" @click="openModalDelete(formpekerjaan.id[index])" :class="{'opacity-65' : formpekerjaan.status[index] == true}" :disabled="formpekerjaan.status[index] == true"><i class="fa-solid fa-trash"></i> Hapus</DangerButton>
                </td>
                <td class="whitespace-nowrap px-6 py-4 font-medium" v-if="users == 'pemilik_lahan'">
                <Checkbox @click="check(index)" v-model="formpekerjaan.status[index]" class="bg-gray-400 opacity-50" :checked="formpekerjaan.status[index] == true" disabled/>
                </td>
                <span v-if="users == 'admin' || users == 'pemilik_lahan'">
                <td class="whitespace-nowrap px-6 py-4 font-medium" v-if="formpekerjaan.status[index]">- Pekerjaan dimulai: {{format(new Date(formpekerjaan.created_at[index]), "dd/MM/yyyy")}}
                , Status: selesai {{format(new Date(formpekerjaan.pekerjaan_selesai[index]), "dd/MM/yyyy")}}</td>
                <td  class="whitespace-nowrap px-6 py-4 font-medium" v-if="formpekerjaan.status[index] == 0">- Pekerjaan dimulai: {{format(new Date(formpekerjaan.created_at[index]), "dd/MM/yyyy")}}
                , Status: lahan sedang diproses</td>
                </span>
                <td class="whitespace-nowrap px-6 py-4" v-if="users == 'petani'">
                <Checkbox :class="{'opacity-50' : formpekerjaan.status[index] == true}" :disabled="formpekerjaan.status[index] == true" @click="check(index)" v-model="formpekerjaan.status[index]" class="bg-gray-400" :checked="formpekerjaan.status[index] == true"/>
                </td>
                <td class="whitespace-nowrap px-6 py-4" v-if="users == 'petani'">
                Pekerjaan ditambahkan pada: {{format(new Date(formpekerjaan.created_at[index]), "dd/MM/yyyy")}}
                </td>
            </tr>
            </tbody>
            </table> 
         </div>

         <!-- modal -->
        <Modal :show="modalDelete" @close="closeModalDelete">
        <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Apakah anda yakin akan menghapus?
                </h2>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModalDelete"> Cancel </SecondaryButton>
                    <DangerButton
                        class="ms-3"
                        @click="deletePekerjaan(selectedIndex)"
                    >
                       Hapus
                    </DangerButton>
                </div>
              </div>
        </Modal>

        <Modal :show="modalEdit" @close="closeModalEdit">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Edit Pekerjaan
                </h2>
                <TextInput
                        id="deskripsipekerjaan"
                        type="text"
                        class="mt-1 block w-full capitalize"
                        autofocus
                        autocomplete="deskripsipekerjaan"
                        placeholder="Masukan deskripsi pekerjaan"
                        v-model="form.deskripsi"
                    />
                    <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModalEdit"> Cancel </SecondaryButton>
                    <PrimaryButton @click="editPekerjaan"
                    class="ms-3">Save</PrimaryButton>
                    </div>
            </div>
        </Modal>

        <Modal :show="modalAdd" @close="closeModalAdd">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Tambah Pekerjaan
                </h2>
                <TextInput
                        id="deskripsipekerjaan"
                        type="text"
                        class="mt-1 block w-full capitalize"
                        autofocus
                        autocomplete="deskripsipekerjaan"
                        placeholder="Masukan deskripsi pekerjaan"
                        v-model="form.deskripsi"
                    />
                    <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModalAdd"> Cancel </SecondaryButton>
                    <PrimaryButton @click="addPekerjaan"
                    class="ms-3">Save</PrimaryButton>
                    </div>
            </div>
        </Modal>
        </div>
        </header>
      </section> 
</template>