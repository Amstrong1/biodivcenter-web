<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from './Header.vue';
import Footer from './Footer.vue';
import Map from './Map.vue';

</script>

<template>

  <Head title="Sites" />

  <div class="min-h-screen flex flex-col">
    <Header />

    <main class="lg:px-28 px-12 grow">
      <div class="lg:grid grid-cols-12 gap-8 my-12">
        <!-- Liste des sites -->
        <div class="col-span-8">
          <div class="flex items-center justify-between mb-4">
            <span class="font-semibold tracking-wide">Listes des sites</span>
            <div class="relative">
              <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-800" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"></path>
                </svg>
              </div>
              <input type="text" id="custom-search-input"
                class="border-0 block p-2 pl-10 w-80 text-sm form-input placeholder:text-gray-800 bg-[#f1f4ef] rounded-lg"
                placeholder="Rechercher dans la liste" />
            </div>
          </div>

          <div class="p-6 bg-[#f1f4ef] rounded-lg overflow-x-auto">
            <table class="w-full whitespace-nowrap">
              <thead>
                <tr class="rounded-lg font-semibold tracking-wide border-b text-left bg-[#ddf3d1]">
                  <th class="px-6 py-4"></th>
                  <th class="px-6 py-4">Nom du site</th>
                  <th class="px-6 py-4">Pays</th>
                  <th class="px-6 py-4">Adresse</th>
                  <th class="px-6 py-4">Action</th>
                </tr>
              </thead>

              <tbody class="text-sm">
                <tr v-for="site in $page.props.sites" :key="site.slug" class="border-b border-slate-500">
                  <td class="px-6 py-4">
                    <img class="w-8 h-8 rounded-full"
                      :src="site.logo != null ? `/storage/${site.logo}` : '/assets/icon/user.png'" :alt="site.name" />
                  </td>
                  <td class="px-6 py-4">{{ site.name }}</td>
                  <td class="px-6 py-4">{{ site.ong_country }}</td>
                  <td class="px-6 py-4">{{ site.address }}</td>
                  <td class="px-6 py-4">
                    <Link :href="route('guest.sites.show', site.id)"
                      class="p-2 px-4 rounded-full bg-[#ddf3d1] text-primary font-bold">
                    Voir
                    </Link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Carte des sites -->
        <div class="col-span-4 lg:my-0 mt-12">
          <span class="font-semibold tracking-wide block mb-8">Carte des sites</span>
          <div class="p-6 bg-[#f1f4ef] rounded-lg h-full">
            <Map :initialMarkers="$page.props.initialMarkers" />
          </div>
        </div>
      </div>
    </main>

    <Footer />
  </div>
</template>
