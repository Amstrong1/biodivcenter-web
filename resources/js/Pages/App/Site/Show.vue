<template>

    <Head title="Site" />
    <AuthenticatedLayout>
        <div class="mb-8 flex gap-8">
            <div class="w-2/3" v-for="(card, index) in $page.props.infoCards" :key="index">
                <InfoCard :title="card.title" :infoList="card.infoList" />
            </div>

            <div class="w-1/3 bg-gray-100 p-8 rounded-lg shadow-md">
                <span class="font-semibold tracking-wide">Carte du site</span>
                <hr class="mt-2 mb-6 h-1 bg-black rounded-lg">
                <div class="h-[80%]">
                    <Map :initialMarkers="$page.props.initialMarkers" />
                </div>
            </div>
        </div>

        <div class="mb-8">
            <span class="font-bold tracking-wide block mb-4">Liste des espèces du site</span>
            <div class="p-6 bg-[#f1f4ef] rounded-lg overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="rounded-lg font-semibold tracking-wide border-b text-left bg-[#ddf3d1]">
                            <!-- <th class="px-6 py-4"></th> -->
                            <th class="px-6 py-4">Nom de l'espece</th>
                            <th class="px-6 py-4">Nom scientifique</th>
                            <th class="px-6 py-4">Status CITES</th>
                            <th class="px-6 py-4">Status UICN</th>
                            <th class="px-6 py-4">Action</th>
                        </tr>
                    </thead>

                    <tbody class="text-sm">
                        <tr v-if="$page.props.species.length !== 0" v-for="specie in $page.props.species" :key="specie.id"
                            class="border-b border-slate-500">
                            <!-- <td class="px-6 py-4">
                                <img class="w-8 h-8 rounded-full"
                                :src="site.photo != null ? `/storage/${specie.photo}` : '/assets/icon/user.png'" :alt="site.name" />
                            </td> -->
                            <td class="px-6 py-4">{{ specie.french_name }}</td>
                            <td class="px-6 py-4">{{ specie.scientific_name }}</td>
                            <td class="px-6 py-4">{{ specie.status_cites }}</td>
                            <td class="px-6 py-4">{{ specie.status_uicn }} </td>
                            <td class="px-6 py-4">
                                <Link :href="route('species.show', specie.id)"
                                    class="p-2 px-4 rounded-full bg-[#ddf3d1] text-primary font-bold">
                                Voir
                                </Link>
                            </td>
                        </tr>
                        <tr v-else>
                            <td class="px-6 py-4 text-center text-xs" colspan="5">Aucune espece dans ce site</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 flex gap-2 text-sm">
            <Link class="md:w-1/2 bg-[#ddf3d1] py-2 rounded-lg font-bold text-center" :href="route('sites.index')">
            Retour
            </Link>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InfoCard from '@/Components/Form/Show.vue'
import { Head, Link } from '@inertiajs/vue3';
import Map from '@/Pages/Map.vue';
</script>