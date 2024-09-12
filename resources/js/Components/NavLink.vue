<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'px-8 py-2 bg-primary text-white rounded-xl'
        : ''
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
