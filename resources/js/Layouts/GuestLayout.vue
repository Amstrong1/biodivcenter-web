<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

// Importation des images
const gridOneImages = [
    "/assets/img/landing1.jpg",
    "/assets/img/landing2.jpg",
    "/assets/img/landing4.jpg",
    "/assets/img/landing3.jpg",
];
const gridTwoImages = [
    "/assets/img/landing3.jpg",
    "/assets/img/landing1.jpg",
    "/assets/img/landing4.jpg",
    "/assets/img/landing2.jpg",
];
const gridThreeImages = [
    "/assets/img/landing4.jpg",
    "/assets/img/landing3.jpg",
    "/assets/img/landing1.jpg",
    "/assets/img/landing2.jpg",
];
const gridFourImages = [
    "/assets/img/landing2.jpg",
    "/assets/img/landing4.jpg",
    "/assets/img/landing3.jpg",
    "/assets/img/landing1.jpg",
];
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="fixed top-0 left-0 w-full overflow-hidden grid grid-cols-12 gap-2 h-screen-vh">
            <div class="col-span-3 flex flex-col gap-2">
                <img class="h-auto max-w-full object-cover object-center" v-for="(image, index) in gridOneImages"
                    :key="index" :src="image" alt="gallery-photo" />
            </div>

            <div class="col-span-3 flex flex-col gap-2">
                <img class="h-auto max-w-full object-cover object-center" v-for="(image, index) in gridTwoImages"
                    :key="index" :src="image" alt="gallery-photo" />
            </div>

            <div class="col-span-3 flex flex-col gap-2">
                <img class="h-auto max-w-full object-cover object-center" v-for="(image, index) in gridThreeImages"
                    :key="index" :src="image" alt="gallery-photo" />
            </div>

            <div class="col-span-3 flex flex-col gap-2">
                <img class="h-auto max-w-full object-cover object-center" v-for="(image, index) in gridFourImages"
                    :key="index" :src="image" alt="gallery-photo" />
            </div>
        </div>

        <div class="relative flex items-center justify-center w-full">
            <slot />
        </div>
    </div>
</template>
