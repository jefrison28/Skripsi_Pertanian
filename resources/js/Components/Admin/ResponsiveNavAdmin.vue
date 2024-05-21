<script setup>
import ResponsiveNavLink from '../ResponsiveNavLink.vue';
</script>

<template>
<ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                Dashboard
</ResponsiveNavLink>

<ResponsiveNavLink :href="route('petanipage.view')" :active="route().current('petanipage.view')">
                Data Petani
</ResponsiveNavLink>

<ResponsiveNavLink :href="route('lahanpage.view')" :active="route().current('lahanpage.view')">
                Data Pemilik Lahan
</ResponsiveNavLink>
</template>