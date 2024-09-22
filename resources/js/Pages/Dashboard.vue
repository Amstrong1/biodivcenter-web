<script setup>
import { onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SpeciesCard from '@/Components/Card.vue';
import { Chart } from 'chart.js/auto';


const props = defineProps({
    speciesCount: Number,
    animalsCount: Number,
    siteCount: Number,
    newBornCount: Number,
    chartData: Object
})

onMounted(() => {
    const ctx = document.getElementById('myChart').getContext('2d');
    const ctx2 = document.getElementById('myChart2').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: props.chartData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                }
            },
            plugins: {
                legend: {
                    display: false  // Cacher la légende si nécessaire
                }
            },
            barPercentage: 0.2,
            categoryPercentage: 1
        }
    });

    new Chart(ctx2, {
        type: 'bar',
        data: props.chartData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                }
            },
            plugins: {
                legend: {
                    display: false  // Cacher la légende si nécessaire
                }
            },
            barPercentage: 0.2,
            categoryPercentage: 1
        }
    });
});
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="grid sm:grid-rows-4 md:grid-rows-1 md:grid-cols-4 gap-4">
                <SpeciesCard icon1="pets.png" title="Nbre d'espèces total" :value="speciesCount ?? 0"
                    icon2="trend.png" />
                <SpeciesCard icon1="deer.png" title="Nbre d'individus total" :value="animalsCount ?? 0"
                    icon2="trend.png" />
                <SpeciesCard icon1="map-marker.png" title="Nbre de sites total" :value="siteCount ?? 0"
                    icon2="trend.png" />
                <SpeciesCard icon1="paw-heart.png" title="Nbre de nouvelles naissances" :value="newBornCount ?? 0"
                    icon2="trend.png" />
            </div>

            <div class="grid md:grid-cols-2 gap-4 mt-4">
                <div class="p-6 bg-[#f1f4ef] rounded-lg">
                    <div class="flex items-center justify-between mb-10">
                        <span class="font-semibold tracking-wide text-sm">Nombre d'espèce par ONG</span>
                        <select class="text-xs rounded-lg bg-[#ddf3d1] border-0 outline-none focus:ring-0 focus:border-0 focus:ring-offset-0">
                            <option value="">Tout</option>
                            <option value="">ONG1</option>
                            <option value="">ONG2</option>
                            <option value="">ONG3</option>
                        </select>
                    </div>
                    <canvas id="myChart"></canvas>
                </div>

                <div class="p-6 bg-[#f1f4ef] rounded-lg">
                    <div class="flex items-center justify-between mb-10">
                        <span class="font-semibold tracking-wide text-sm">Nombre d'individus par espèces</span>
                        <select class="text-xs rounded-lg bg-[#ddf3d1] border-0 outline-none focus:ring-0 focus:border-0 focus:ring-offset-0">
                            <option value="">Tout</option>
                            <option value="">ONG1</option>
                            <option value="">ONG2</option>
                            <option value="">ONG3</option>
                        </select>
                    </div>
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
canvas {
    max-width: 600px;
    margin: auto;
}
</style>