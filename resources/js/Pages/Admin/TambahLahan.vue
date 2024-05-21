<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Swal from 'sweetalert2'
import { onMounted, ref } from 'vue';
import BackButton from '@/Components/BackButton.vue';


const data = usePage().props;
const showToast = () => {
    Swal.fire({
    title: "Informasi",
    text: "Terdapat 3 tahap pengisian form, selesaikan sampai tahap terakhir!",
    icon: "info"
});
};

const form = useForm({
    namalahan : '',
    alamat_lahan : '',
    luas_lahan : '',
    latitude: '',
    longitude : '',
    deskripsi_pekerjaan : [],
    petani : [],
    pemilik : data.id
});

onMounted(() => {
    showToast()
});

const step = ref(1);
const nextStep = () => {
    step.value++
};

const prevStep = () => {
    step.value--
};

const addPetani = () => {
    form.petani.push('');
};

const removePetani = (index) => {
    form.petani.splice(index, 1);
};

const addPekerjaan = () => {
    form.deskripsi_pekerjaan.push('');
}

const removePekerjaan = (index) => {
    form.deskripsi_pekerjaan.splice(index, 1);
}

const submitForm = () => {
Swal.fire({
  title: "Konfirmasi",
  text: "Apakah anda yakin form yang anda isi sudah benar?",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  cancelButtonText: "Tidak",
  confirmButtonText: "Ya!"
}).then((result) => {
  if (result.isConfirmed) {
    form.post(route('insertLahan'))
  }
});
}

const pemilik = data.pemilik;
const petani = data.petani;
console.log(data);

</script>

<template>
   <Head title="Tambah Lahan" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{data.header}}</h2>
            <BackButton/>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                    <p class="mb-1">{{step}}/3</p>
                        <div class="w-full bg-gray-200 rounded-full h-1 dark:bg-gray-700">
                        <div v-if="step == 1" class="bg-blue-600 h-1 rounded-full" style="width: 33%"></div>
                        <div v-if="step == 2" class="bg-blue-600 h-1 rounded-full" style="width: 66%"></div>
                        <div v-if="step == 3" class="bg-blue-600 h-1 rounded-full" style="width: 100%"></div>
                        </div>
                        
                        <div v-if="step == 1" class="space-y-6 mt-8">
                            <h2 class="text-lg font-medium text-gray-900">Informasi Data Lahan</h2>
                            <div class="mt-3">
                            <InputLabel for="pemilik" value="Pemilik Lahan" />
                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 capitalize" id="grid-state role" name="role" v-model="form.pemilik" readonly>
                            <option v-if="pemilik.length > 0" value="">Pilih Pemilik Lahan</option>
                            <option v-for="(item, index) in pemilik" :key="index" :value="item.id">{{item.name}}</option>
                            </select>
                            </div>

                            <div class="mt-3">
                            <InputLabel for="namalahan" value="Nama Lahan" /> 
                            <TextInput
                                id="namalahan"
                                type="text"
                                class="mt-1 block w-full capitalize"
                                autofocus
                                autocomplete="namalahan"
                                placeholder="Masukan nama lahan"
                                v-model="form.namalahan"
                            />
                            </div>

                            <div class="mt-3">
                            <InputLabel for="alamatlahan" value="Alamat Lahan" /> 
                            <TextInput
                                id="alamatlahan"
                                type="text"
                                class="mt-1 block w-full capitalize"
                                autofocus
                                autocomplete="alamatlahan"
                                placeholder="Masukan alamat lahan"
                                v-model="form.alamat_lahan"
                            />
                            </div>

                            <div class="mt-3">
                            <InputLabel for="luaslahan" value="Luas Lahan dalam m&sup2;" />
                            <TextInput
                                id="luaslahan"
                                type="number"
                                class="mt-1 block w-full capitalize"
                                autofocus
                                autocomplete="luaslahan"
                                placeholder="Masukan luas lahan"
                                v-model="form.luas_lahan"
                            />
                            </div>

                            <div class="mt-2">
                            <InputLabel for="latitude" value="Latitude" />
                            <TextInput
                                id="latitude"
                                type="text"
                                class="mt-1 block w-full capitalize"
                                autofocus
                                autocomplete="latitude"
                                placeholder="Masukan latitude"
                                v-model="form.latitude"
                            />
                            </div>

                            <div class="mt-2">
                            <InputLabel for="longitude" value="longitude" />
                            <TextInput
                                id="longitude"
                                type="text"
                                class="mt-1 block w-full capitalize"
                                autofocus
                                autocomplete="longitude"
                                placeholder="Masukan longitude"
                                v-model="form.longitude"
                            />
                            </div>

                            <button @click="nextStep" class="mt-4 px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white rounded">Next <i class="fa-solid fa-arrow-right"></i></button>
                        </div>

                        <div v-if="step==2" class="space-y-6 mt-8">
                            <h2 class="text-lg font-medium text-gray-900">Tambah Data Petani</h2>
                            <p class="text-sm text-gray-600">Tambahkan data petani yang akan mengerjakan lahan ini.</p>

                            <div class="mt-3">
                            <InputLabel for="daftarpetani" value="Daftar Petani" />
                            <div v-for="(item, index) in form.petani" :key="index" class="mt-3">
                                <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 capitalize" v-model="form.petani[index]">
                                <option v-if="petani.length > 0" :value="[]">Pilih Petani</option>
                                <option v-for="(petaniItem, petaniIndex) in petani" :key="petaniIndex" :value="petaniItem.id" :disabled="petaniItem.jumlah_pekerjaan >= 3">{{ petaniItem.name }} {{ petaniItem.jumlah_pekerjaan >= 3 ? '(jumlah maksimum pekerjaan lahan sudah melebihi batas)' : '' }}</option>
                                </select>
                                <button @click="removePetani(index)" class="mt-2 text-xs bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"><i class="fa-solid fa-trash"></i> Hapus</button>
                            </div>
                            <button class="mt-2 text-sm bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="addPetani"><i class="fa-solid fa-plus"></i> Add More</button>
                            </div>

                            <button @click="prevStep" class="mt-4 px-4 py-2 mr-1 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-100 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-100 dark:border-gray-100 dark:text-dark dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white rounded"><i class="fa-solid fa-arrow-left"></i> Back</button>
                            <button @click="nextStep" class="mt-4 px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white rounded">Next <i class="fa-solid fa-arrow-right"></i></button>
                        </div>

                        <div v-if="step==3" class="space-y-6 mt-8">
                            <h2 class="text-lg font-medium text-gray-900">Deskripsi Pekerjaan Lahan</h2>
                            <p class="text-sm text-gray-600">Tambahkan pekerjaan yang harus dikerjakan petani untuk lahan ini.</p>

                            <div class="mt-3">
                                <InputLabel for="deskripsipekerjaan" value="Deskripsi Pekerjaan" />
                                <div v-for="(item, index) in form.deskripsi_pekerjaan" :key="index" class="mt-3">
                                <TextInput
                                id="deskripsipekerjaan"
                                type="text"
                                class="mt-1 block w-full capitalize"
                                autofocus
                                autocomplete="deskripsipekerjaan"
                                placeholder="Masukan deskripsi pekerjaan"
                                v-model="form.deskripsi_pekerjaan[index]"
                            />
                            <button @click="removePekerjaan(index)" class="mt-2 text-xs bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"><i class="fa-solid fa-trash"></i> Hapus</button>
                            </div>
                            <button class="mt-2 text-sm bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="addPekerjaan"><i class="fa-solid fa-plus"></i> Add More</button>
                            </div>

                            <button @click="prevStep" class="mt-4 px-4 py-2 mr-1 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-100 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-100 dark:border-gray-100 dark:text-dark dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white rounded"><i class="fa-solid fa-arrow-left"></i> Back</button>
                            <button @click="submitForm" class="mt-4 px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white rounded">Submit</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>