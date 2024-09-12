<template>

    <Head title="Site" />
    <AuthenticatedLayout>
        <div v-for="(card, index) in $page.props.infoCards" :key="index">
            <InfoCard :title="card.title" :infoList="card.infoList" />
        </div>

        <!-- Localisation avec image
        <div class="bg-gray-100 p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold border-b pb-2">Localisation</h2>
            <img :src="papillon.localisation_image" alt="Carte de localisation"
                class="w-full h-64 object-cover mt-4 rounded-md">
        </div> -->

        <div class="mt-4 flex gap-2 text-sm">
            <Link class="md:w-1/2 bg-[#ddf3d1] py-2 rounded-lg font-bold text-center" :href="route('sites.index')">
            Retour
            </Link>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InfoCard from '@/Components/Form/Show.vue'
import { Head, Link } from '@inertiajs/vue3';
</script>