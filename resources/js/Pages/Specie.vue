<script setup>
import { Head } from '@inertiajs/vue3';
import Header from './Header.vue';
import Footer from './Footer.vue';

</script>

<template>

    <Head title="Espèces" />

    <div class="min-h-screen flex flex-col">
        <Header />

        <main class="lg:px-28 px-12 grow">
            <div class="my-12">
                <div class="flex items-center justify-between mb-8">
                    <span class="font-semibold tracking-wide">Listes des espèces</span>

                    <div class="relative">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-800" aria-hidden="true" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" id="custom-search-input"
                            class="border-0 block p-2 pl-10 w-80 text-sm form-input placeholder:text-gray-800 bg-[#f1f4ef] rounded-lg"
                            placeholder="Rechercher dans la liste">
                    </div>
                </div>

                <div class="p-6 bg-[#f1f4ef] rounded-lg overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="font-semibold tracking-wide border-b text-left bg-[#ddf3d1]">
                                <th class="px-6 py-4">Nom francais</th>
                                <th class="px-6 py-4">Nom scientifique</th>
                                <th class="px-6 py-4">Nombre d'individus</th>
                                <th class="px-6 py-4">Statut CITES</th>
                                <th class="px-6 py-4">Statut UICN</th>
                            </tr>
                        </thead>

                        <tbody class="text-sm">
                            <tr v-for="specie in $page.props.species" class="border-b border-slate-500">
                                <td class="px-6 py-4">{{ specie.french_name }}</td>
                                <td class="px-6 py-4">{{ specie.scientific_name }}</td>
                                <td class="px-6 py-4">{{ specie.animals_count }}</td>
                                <td class="px-6 py-4">{{ specie.status_cites }}</td>
                                <td class="px-6 py-4">{{ specie.status_uicn }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>
