<template>
    <div class="bg-[#ddf3d1] rounded-lg p-6 w-full text-sm flex flex-col gap-4">
        <div class="flex items-center gap-2 justify-between">
            <div class="bg-white rounded-xl p-2">
                <img class="" :src="`/assets/icon/${icon1}`" alt="" srcset="">
            </div>
            <p class="text-gray-700 font-medium">{{ title }}</p>
        </div>

        <div class="flex justify-between items-center">
            <p class="text-primary text-3xl font-bold">{{ value }}</p>
            <img class="w-6 h-auto" :src="`/assets/icon/${icon2}`" alt="" srcset="">
        </div>
    </div>
</template>

<script setup>
defineProps({
    icon1: {
        type: Object,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    value: {
        type: Number,
        required: true,
    },
    icon2: {
        type: Object,
        required: true,
    }
});
</script>

<style scoped>
/* Vous pouvez ajouter des styles supplémentaires ici si nécessaire */
</style>