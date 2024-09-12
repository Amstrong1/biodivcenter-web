<template>
    <div class="space-y-6">
        <!-- Image de l'entête -->
        <div class="relative">
            <img :src="$page.props.photo" alt="Image de l'animal" class="w-full h-72 object-cover rounded-t-lg">
            <div class="absolute bottom-5 left-5 text-white">
                <h1 class="text-3xl font-bold">{{ $page.props.name }}</h1>
                <p class="text-lg italic">{{ $page.props.speci_name }}</p>
            </div>
        </div>

        <!-- Boucle sur les infoCards -->
        <div v-for="(card, index) in infoCards" :key="index">
            <InfoCard :title="card.title" :infoList="card.infoList" />
        </div>

        <!-- Localisation avec image
        <div class="bg-gray-100 p-4 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold border-b pb-2">Localisation</h2>
            <img :src="papillon.localisation_image" alt="Carte de localisation"
                class="w-full h-64 object-cover mt-4 rounded-md">
        </div> -->
    </div>
</template>

<script setup>
import InfoCard from '@/Components/Form/Show.vue'
</script>