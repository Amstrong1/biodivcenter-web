<template>
    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold border-b pb-2">{{ props.title }}</h2>
        <div class="mt-4 flex flex-col" v-for="(value, key) in props.infoList" :key="key">
            <span class="text-xs">{{ key }} </span>
            <span class="font-semibold text-sm">{{ value }}</span>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    title: String,
    infoList: Object
})
</script>