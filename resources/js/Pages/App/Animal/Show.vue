<template>
    <!-- Image de l'entête -->

    <Head title="Site" />

    <AuthenticatedLayout>
        <div class="mb-8">
            <img :src="`/storage/${$page.props.photo}`" alt="Image de l'animal" class="md:w-1/2 h-72 object-cover rounded-lg">
            <div class="mt-2">
                <h1 class="text-3xl font-bold">{{ $page.props.name }}</h1>
                <p class="text-lg italic">{{ $page.props.specie_name }}</p>
            </div>
        </div>

        <!-- Boucle sur les infoCards -->
        <div v-for="(card, index) in $page.props.infoCards" :key="index">
            <InfoCard :title="card.title" :infoList="card.infoList" />
        </div>
        
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