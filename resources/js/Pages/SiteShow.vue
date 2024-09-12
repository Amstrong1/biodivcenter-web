<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from './Header.vue';
import Footer from './Footer.vue';
import Map from './Map.vue';

</script>

<template>

    <Head title="Espèces" />

    <Header />

    <main class="lg:px-28 px-12 grow">
        <div class="lg:grid grid-cols-12 gap-8 my-12">
            <div class="col-span-8 p-6 bg-[#f1f4ef] rounded-lg">
                <span class="font-semibold tracking-wide text-primary block w-full border-b border-primary pb-2">Nom du
                    site</span>
                <div class="grid md:grid-cols-2 grid-cols-1 gap-4 pt-8">
                    <input class="w-full bg-white rounded-lg" type="text" readonly value="">
                    <input class="w-full bg-white rounded-lg" type="text" readonly value="">
                    <input class="w-full bg-white rounded-lg" type="text" readonly value="">
                    <input class="w-full bg-white rounded-lg" type="text" readonly value="">
                    <input class="w-full bg-white rounded-lg" type="text" readonly value="">
                    <input class="w-full bg-white rounded-lg" type="text" readonly value="">
                    <input class="w-full bg-white rounded-lg" type="text" readonly value="">
                    <input class="w-full bg-white rounded-lg" type="text" readonly value="">
                    <input class="w-full bg-white rounded-lg" type="text" readonly value="">
                    <input class="w-full bg-white rounded-lg" type="text" readonly value="">
                </div>
            </div>

            <div class="col-span-4 lg:my-0 mt-12 bg-[#f1f4ef] rounded-lg p-6">
                <span class="font-semibold tracking-wide text-primary block w-full border-b border-primary pb-2">Carte
                    des
                    sites</span>
                <div class="mt-4">
                    <Map :sites="sites" :initialMarkers="initialMarkers" />
                </div>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-8">
                <span class="font-bold">Liste des espèces présentes sur le site</span>

                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-800" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd">
                            </path>
                        </svg>
                    </div>
                    <input type="text" id="custom-search-input"
                        class="border-0 block p-2 pl-10 w-80 text-sm form-input placeholder:text-gray-800 bg-[#f1f4ef] rounded-lg"
                        placeholder="Rechercher dans la liste">
                </div>
            </div>

            <div class="p-6 my-6 bg-[#f1f4ef] rounded-lg overflow-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="font-semibold tracking-wide border-b text-left bg-[#ddf3d1]">
                            <th class="px-6 py-4">Nom du site</th>
                            <th class="px-6 py-4">ONG Responsable</th>
                            <th class="px-6 py-4">Pays</th>
                            <th class="px-6 py-4">Commune</th>
                        </tr>
                    </thead>

                    <tbody class="text-sm">
                        <tr class="border-b border-slate-500">
                            <td class="px-6 py-4">Site1</td>
                            <td class="px-6 py-4">ONG1</td>
                            <td class="px-6 py-4">Benin</td>
                            <td class="px-6 py-4">Commune</td>
                        </tr>

                        <tr class="border-b border-slate-500">
                            <td class="px-6 py-4">Site1</td>
                            <td class="px-6 py-4">ONG1</td>
                            <td class="px-6 py-4">Benin</td>
                            <td class="px-6 py-4">Commune</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <Footer />
</template>
