<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, computed } from 'vue';
import { format } from "date-fns";
import DangerButton from '@/Components/DangerButton.vue';

const prop = defineProps({
    lahan :{
        type:Object,
        default: () => ({})
    }
});
const lahan = computed(() => prop.lahan)
const lahanform = useForm({
    'id' : prop.lahan.id,
    'namalahan' : prop.lahan.namalahan,
    'alamat_lahan' : prop.lahan.alamat_lahan,
    'latitude' : prop.lahan.latitude,
    'longitude' : prop.lahan.longitude,
    'luas_lahan' : prop.lahan.luas_lahan
});
const isEdit = ref(false)
const user = usePage().props.auth.user;
const edit = () => {
    isEdit.value = true
};
const updateInformasiLahan = () => {
    lahanform.patch(route('informasiLahan.update'), {
        preserveScroll: true,
        onSuccess: () => isEdit.value = false,
    });
};
console.log(lahan)
</script>

<template>
   <section class="space-y-6">
                    <header>
                    <h2 class="text-lg font-medium text-gray-900">Informasi Lahan</h2>
                    <p v-if="prop.lahan.status == true">Status Pekerjaan Lahan: Selesai dikerjaan pada {{format(new Date(prop.lahan.pekerjaan_selesai), "dd/MM/yyyy")}}</p>
                    <p v-else>Status Pekerjaan Lahan: Sedang Dalam Pengerjaan</p>
                    </header>
                    <button @click="edit" class="mt-3 px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white" v-if="user.role == 'admin'" :disabled="isEdit == true" :class="{'opacity-50' : isEdit == true}">Edit</button>
                    <form @submit.prevent="updateInformasiLahan" class="mt-6 space-y-6">
                    <div class="mt-3">
                            <InputLabel for="namalahan" value="Nama Lahan" /> 
                            <TextInput
                                id="namalahan"
                                type="text"
                                class="mt-1 block w-full capitalize"
                                autofocus
                                autocomplete="namalahan"
                                placeholder="Masukan nama lahan"
                                v-model="lahanform.namalahan"
                                :readonly="isEdit == false"
                                :class="{'opacity-65' : isEdit == false}"
                            />
                            <InputError :message="lahanform.errors.namalahan" class="mt-2" />
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
                                v-model="lahanform.alamat_lahan"
                                :readonly="isEdit == false"
                                :class="{'opacity-65' : isEdit == false}"
                            />
                            <InputError :message="lahanform.errors.alamat_lahan" class="mt-2" />
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
                                v-model="lahanform.luas_lahan"
                                :readonly="isEdit == false"
                                :class="{'opacity-65' : isEdit == false}"
                            />
                            <InputError :message="lahanform.errors.luas_lahan" class="mt-2" />
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
                                v-model="lahanform.latitude"
                                :readonly="isEdit == false"
                                :class="{'opacity-65' : isEdit == false}"
                            />
                            <InputError :message="lahanform.errors.latitude" class="mt-2" />
                     </div>
                     <div class="mt-2">
                            <InputLabel for="longitude" value="longitude"  />
                            <TextInput
                                id="longitude"
                                type="text"
                                class="mt-1 block w-full capitalize"
                                :class="{'opacity-65' : isEdit == false}"
                                autofocus
                                autocomplete="longitude"
                                placeholder="Masukan longitude"
                                v-model="lahanform.longitude"
                                :readonly="isEdit == false"
                            />
                            <InputError :message="lahanform.errors.longitude" class="mt-2" />
                            </div>
                            <div class="flex items-center gap-4" v-if="user.role == 'admin'">
                                <button class="mt-3 px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white" type="submit" :disabled="isEdit == false" :class="{'opacity-50' : isEdit == false}"
                                >Save</button>
                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="lahanform.recentlySuccessful" class="text-sm text-gray-600">Disimpan.</p>
                                </Transition>
                            </div>
                            </form>
   </section>
</template>