<template>
    <Link :href="href" class="flex items-center space-x-2 rounded-lg px-4 py-2 my-1 gap-2"
        :class="isActiveRoute == true ? 'font-semibold bg-[#ddf3d1]' : ''">
        <!-- Icône par défaut -->
        <img v-if="isActiveRoute == false" class="w-5 h-auto" :src="`/assets/icon/${icon}`" alt="" srcset="">      

        <!-- Icône au survol -->
        <img v-else class="w-5 h-auto" :src="`/assets/icon/${srIcon}`" alt="" srcset="">      

        <span>{{ label }}</span>
    </Link>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
        required: true,
    },
    srIcon: {
        type: String,
        required: true,
    },
})

const isActiveRoute = ref(false)

if (props.href === window.location.pathname) {
    isActiveRoute.value = true
}

</script>

<style scoped>
/* Ajoutez d'autres styles si nécessaire */
</style>
