<script setup>
import NavLink from '../NavLink.vue';
</script>

<template>
    <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
        Dashboard
    </NavLink>
</template>