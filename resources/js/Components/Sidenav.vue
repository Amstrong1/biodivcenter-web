<template>
    <div class="flex flex-col w-64 h-screen py-8 px-4">
        <div class="flex items-center justify-center h-16">
            <img src="/assets/img/logo.png" alt="logo">
        </div>

        <nav class="flex flex-col flex-1 px-4 pt-12 gap-2 text-sm">
            <IconLink href="/dashboard" label="Accueil" icon="home.png" srIcon="home_sr.png" />
            <IconLink v-if="$page.props.auth.user.role !== 'adminONG'" href="/ongs" label="ONG" icon="briefcase.png" srIcon="briefcase_sr.png" />
            <IconLink href="/sites" label="Sites" icon="map.png" srIcon="map_sr.png" />
            <IconLink href="/animals" label="Animaux" icon="paw-print.png" srIcon="paw-print_sr.png" />
            <IconLink href="/users" label="Utilisateurs" icon="friends.png" srIcon="friends_sr.png" />
            <IconLink href="/observations" label="Observations" icon="telescope.png" srIcon="telescope_sr.png" />
        </nav>
    </div>
</template>

<script setup>
import IconLink from './Iconlink.vue'

</script>

<style scoped>
/* Add any additional styles here */
</style>