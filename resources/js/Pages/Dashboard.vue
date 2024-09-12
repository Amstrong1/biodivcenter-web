<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SpeciesCard from '@/Components/Card.vue';
// import BarChart from '../components/charts/index.vue';

defineProps({
    speciesCount: Number,
    animalsCount: Number,
    siteCount: Number,
    newBornCount: Number
})
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid sm:grid-rows-4 md:grid-rows-4 md:grid-cols-4 gap-4">
                        <SpeciesCard icon1="pets.png" title="Nbre d'espèces total" :value="speciesCount ?? 0" icon2="trend.png" />
                        <SpeciesCard icon1="deer.png" title="Nbre d'individus total" :value="animalsCount ?? 0" icon2="trend.png" />
                        <SpeciesCard icon1="map-marker.png" title="Nbre de sites total" :value="siteCount ?? 0"
                            icon2="trend.png" />
                        <SpeciesCard icon1="paw-heart.png" title="Nbre de nouvelles naissances" :value="newBornCount ?? 0"
                            icon2="trend.png" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
