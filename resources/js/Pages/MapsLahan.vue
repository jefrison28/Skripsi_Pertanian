<script setup>
import { Map, MapStyle, Marker, config } from '@maptiler/sdk';
import { shallowRef, computed, onMounted, onUnmounted, markRaw } from 'vue';
import '@maptiler/sdk/dist/maptiler-sdk.css';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import BackButton from '@/Components/BackButton.vue'

const page = usePage()
const lahan = computed(() => page.props.lahan)
const mapContainer = shallowRef(null);
const map = shallowRef(null);

onMounted(() => {
  config.apiKey = 'MqfzhjSjqI2j7xNT4YWd';
  const long = page.props.lahan.longitude
  const lat = page.props.lahan.latitude

  const initialState = { lng: long, lat: lat, zoom: 14 };

  map.value = markRaw(new Map({
    container: mapContainer.value,
    style: MapStyle.STREETS,
    center: [initialState.lng, initialState.lat],
    zoom: initialState.zoom
  }));

  new Marker({color: "#FF0000"})
  .setLngLat([long,lat])
  .addTo(map.value);

}),
onUnmounted(() => {
  map.value?.remove();
});
</script>

<style scoped>
.map-wrap {
  position: relative;
  width: 100%;
  height: calc(100vh - 77px); /* calculate height of the screen minus the heading */
}

.map {
  position: absolute;
  width: 100%;
  height: 100%;
}
</style>

<template>
  <AuthenticatedLayout>
    <Head title="Maps" />
    <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">Maps {{ lahan.namalahan }}</h2>
            <BackButton/>
        </template>
        <!-- <iframe width="500" height="300" src="https://api.maptiler.com/maps/basic-v2/?key=11cC3TK0yMK9WTqiXQnU#1.0/0.00000/0.00000"></iframe> -->
        <div class="py-0">
          <div class="map-wrap">
        <div class="map" ref="mapContainer"></div>
        </div>
        </div>
  </AuthenticatedLayout>
  </template>
  
