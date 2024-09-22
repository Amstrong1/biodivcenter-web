<template>
    <div class="bg-gray-100 p-8 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold">{{ props.title }}</h2>
        <hr class="mt-2 mb-6 h-1 bg-black rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div class="mt-2 bg-white grid grid-cols-3 px-4 py-2 rounded-xl" v-for="(value, key) in props.infoList"
                :key="key">
                <span class="text-xs">{{ key }} </span>
                <span class="col-span-2 font-semibold text-xs">{{ value }}</span>
            </div>
        </div>

    </div>
</template>

<script setup>
const props = defineProps({
    title: String,
    infoList: Object
})
</script>