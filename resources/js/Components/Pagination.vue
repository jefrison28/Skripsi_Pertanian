<script setup>
import { usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const pagination = usePage().props
const props = defineProps({
    currentPage: {
    type: Number,
    required: true
  },
  totalPages: {
    type: Number,
    required: true
  },
  prev_link :{
    type:String
  },
  next_link :{
    type:String
  },
  disablePrev : {
    type:Boolean
  },
  disableNext: {
    type:Boolean
  },
});

const navigateToNextPage = (link) => {
    window.location.href = link;
};

const navigateToPrevPage = (link) => {
    window.location.href = link;
};
</script>

<template>
<div class="flex items-center gap-4 mt-5">
  <button @click="navigateToPrevPage(prev_link)" :disabled="disablePrev"
    class="flex items-center gap-2 px-6 py-3 font-sans text-xs font-bold text-center text-gray-900 uppercase align-middle transition-all rounded-lg select-none hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
    type="button">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
      aria-hidden="true" class="w-4 h-4">
      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
    </svg>
    Previous
  </button>
  <div class="flex items-center gap-2">
    <button
      class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg bg-gray-900 text-center align-middle font-sans text-xs font-medium uppercase text-white shadow-md shadow-gray-900/10 transition-all hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
      type="button">
      <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
        {{currentPage}}
      </span>
    </button>
  </div>
  <button @click="navigateToNextPage(next_link)" :disabled="disableNext"
    class="flex items-center gap-2 px-6 py-3 font-sans text-xs font-bold text-center text-gray-900 uppercase align-middle transition-all rounded-lg select-none hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
    type="button">
    Next
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
      aria-hidden="true" class="w-4 h-4">
      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
    </svg>
</button>
</div> 
</template>