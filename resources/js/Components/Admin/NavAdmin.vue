<script setup>
import NavLink from '../NavLink.vue';

</script>

<template>
<!-- Navigation Links -->
     <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
        Dashboard
       </NavLink>

       <NavLink :href="route('petanipage.view')" :active="route().current('petanipage.view')">
        Data Petani
       </NavLink>

       <NavLink :href="route('lahanpage.view')" :active="route().current('lahanpage.view')">
        Data Pemilik Lahan
       </NavLink>
</template>