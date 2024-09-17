<template>

    <Head title="Type d'habitat" />
    <AuthenticatedLayout>
        <div class="mb-8 flex gap-8">
            <div  v-for="(card, index) in $page.props.infoCards" :key="index">
                <InfoCard :title="card.title" :infoList="card.infoList" />
            </div>
        </div>

        <div class="mt-4 flex gap-2 text-sm">
            <Link class="md:w-1/2 bg-[#ddf3d1] py-2 rounded-lg font-bold text-center" :href="route('type-habitats.index')">
            Retour
            </Link>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InfoCard from '@/Components/Form/Show.vue'
import { Head, Link } from '@inertiajs/vue3';
</script>