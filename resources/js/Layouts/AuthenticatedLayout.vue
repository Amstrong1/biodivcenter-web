<script setup>
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Sidenav from '@/Components/Sidenav.vue';

const showingNavigationDropdown = ref(false);

const getPageTitle = () => {
    const routePath = window.location.pathname;

    const routes = [
        { pattern: /^\/dashboard$/, title: 'Tableau de bord' },

        { pattern: /^\/ongs\/?$/, title: 'Liste des ONG' },
        { pattern: /ongs.*edit/, title: 'Modifier les informations de l\'ONG' },

        { pattern: /^\/sites\/?$/, title: 'Liste des sites' },
        { pattern: /sites.*edit/, title: 'Modifier les informations du site' },
        { pattern: /sites/, title: 'Voir les informations du site' },

        { pattern: /profile/, title: 'Voir les informations du profil' },

        { pattern: /^\/users\/?$/, title: 'Liste des utilisateurs' },
        { pattern: /users.*edit/, title: 'Modifier les informations de l\'utilisateur' },
        { pattern: /users./, title: 'Voir les informations de l\'utilisateur' },

        { pattern: /^\/observations\/?$/, title: 'Liste des observations' },
        { pattern: /observations.*edit/, title: 'Modifier les informations de l\'ONG' },
        { pattern: /observations/, title: 'Voir les informations de l\'ONG' },

        { pattern: /^\/branches\/?$/, title: 'Liste des embranchements' },
        { pattern: /branches.*edit/, title: 'Modifier les informations de l\'embranchement' },

        { pattern: /^\/orders\/?$/, title: 'Liste des ordres' },
        { pattern: /orders.*edit/, title: 'Modifier les informations de l\'ordre' },

        { pattern: /^\/families\/?$/, title: 'Liste des familles' },
        { pattern: /families.*edit/, title: 'Modifier les informations de la famille' },

        { pattern: /^\/species\/?$/, title: 'Liste des espèces' },
        { pattern: /species.*edit/, title: 'Modifier les informations de l\'espèce' },
        { pattern: /species/, title: 'Voir les informations de l\'espèce' },

        { pattern: /^\/genera\/?$/, title: 'Liste des genres' },
        { pattern: /^\/genera\/edit/, title: 'Modifier les informations du genre' },

        { pattern: /^\/classifications\/?$/, title: 'Liste des classifications' },
        { pattern: /classifications.*edit/, title: 'Modifier les informations de la classification' },

        { pattern: /^\/reigns\/?$/, title: 'Liste des règnes' },
        { pattern: /reigns.*edit/, title: 'Modifier les informations du règne' },

        { pattern: /^\/animals\/?$/, title: 'Liste des individus des espèces' },
        { pattern: /animals/, title: 'Voir les informations de l\'animal' },

        { pattern: /^\/relocations\/?$/, title: 'Liste des transferts' },
        { pattern: /relocations.*edit/, title: 'Modifier les informations du transfert' },
        { pattern: /relocations/, title: 'Voir les informations du transfert' },

        { pattern: /^\/type-habitats\/?$/, title: 'Liste des types d\'habitat' },
        { pattern: /type-habitats.*edit/, title: 'Modifier les informations du type d\'habitat' },
        { pattern: /type-habitats/, title: 'Voir les informations du type d\'habitat' },
    ];

    for (const route of routes) {
        if (route.pattern.test(routePath)) {
            return route.title;
        }
    }

    return 'Page non trouvée';
}
</script>

<template>
    <div class="flex min-h-screen">
        <header class="w-64 h-screen bg-[#f1f4ef] rounded-r-lg fixed overflow-auto z-40">
            <Sidenav />
        </header>

        <main class="flex-1 mx-auto sm:px-6 lg:px-8 py-12 ml-64">
            <nav class="bg-white">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto">
                    <div class="flex justify-between items-center h-16">
                        <div class="text-2xl text-primary font-bold">
                            {{ getPageTitle() }}
                        </div>

                        <div class="hidden sm:flex sm:ms-6 items-center">
                            <img class="h-12" src="/assets/icon/notification.png" alt="notifications">

                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <div class="flex rounded-md">
                                            <button type="button"
                                                class="flex gap-2 items-center justify-start px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                <img class="h-12 rouded-full" src="/assets/icon/user.png" alt="user">
                                                <div class="flex flex-col items-start">
                                                    <span>{{ $page.props.auth.user.name }}</span>
                                                    <span>{{ $page.props.auth.user.role }}</span>
                                                </div>
                                            </button>
                                        </div>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profil </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Déconnexion
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profil </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Déconnexion
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>
            <hr class="h-0.5 bg-gray-400 rounded-lg mt-2 mb-4">
            <slot />
        </main>
    </div>
</template>
