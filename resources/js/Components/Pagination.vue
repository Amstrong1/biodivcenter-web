<template>
    <div v-if="links.length > 0">
        <div class="flex flex-wrap items-center justify-between mt-10 text-xs">
            <div>
                Affichage de {{ current }} sur {{ total }}
            </div>

            <div class="flex items-center gap-4">
                <div v-for="(link, linkIndex) in links" :key="linkIndex" class="flex items-center justify-end">
                    <div v-if="link.url === null" class=""
                        :class="{ 'border px-3 py-1 rounded-lg border-primary': link.active }" v-html="link.label">
                    </div>

                    <Link v-else :href="link.url" :class="{ 'border px-3 py-1 rounded-lg border-primary': link.active }"
                        class="">
                    <span v-html="link.label"></span>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    links: Array,
    current : Number,
    total : Number
})
</script>
