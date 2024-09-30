<template>
    <div class="flex justify-start items-center bg-[#f1f4ef] rounded-xl py-2 px-4 text-xs gap-8 w-auto mb-4">

        <!-- <Link :href="route('reigns.index')" v-if="$page.props.auth.user.role !== 'adminONG'"
            :class="route().current('reigns.index') ? 'px-8 py-2 bg-primary text-white rounded-xl' : ''">
        Règne
        </Link>
        
        <Link :href="route('branches.index')" v-if="$page.props.auth.user.role !== 'adminONG'"
            :class="route().current('branches.index') ? 'px-8 py-2 bg-primary text-white rounded-xl' : ''">
        Embranchement
        </Link>
        
        <Link :href="route('classifications.index')" v-if="$page.props.auth.user.role !== 'adminONG'"
            :class="route().current('classifications.index') ? 'px-8 py-2 bg-primary text-white rounded-xl' : ''">
        Classe
        </Link>

        <Link :href="route('orders.index')" v-if="$page.props.auth.user.role !== 'adminONG'"
            :class="route().current('orders.index') ? 'px-8 py-2 bg-primary text-white rounded-xl' : ''">
        Ordre
        </Link>
        
        <Link :href="route('families.index')" v-if="$page.props.auth.user.role !== 'adminONG'"
            :class="route().current('families.index') ? 'px-8 py-2 bg-primary text-white rounded-xl' : ''">
        Famille
        </Link>

        <Link :href="route('genera.index')" v-if="$page.props.auth.user.role !== 'adminONG'"
            :class="route().current('genera.index') ? 'px-8 py-2 bg-primary text-white rounded-xl' : ''">
        Genre
        </Link> -->

        <Link :href="route('species.index')" v-if="$page.props.auth.user.role !== 'adminONG'"
            :class="route().current('species.index') ? 'px-8 py-2 bg-primary text-white rounded-xl' : ''">
        Espèces
        </Link>

        <Link :href="route('animals.index')"
            :class="route().current('animals.index') ? 'px-8 py-2 bg-primary text-white rounded-xl' : ''">
        Individus
        </Link>

        <Link :href="route('type-habitats.index')" v-if="$page.props.auth.user.role !== 'adminONG'"
            :class="route().current('type-habitats.index') ? 'px-8 py-2 bg-primary text-white rounded-xl' : ''">
        Type d'habitat
        </Link>

        <Link :href="route('relocations.index')"
            :class="route().current('relocations.index') ? 'px-8 py-2 bg-primary text-white rounded-xl' : ''">
        Transferts
        </Link>

        <Link :href="route('tags.index')" v-if="$page.props.auth.user.role == 'adminONG'"
            :class="route().current('tags.index') ? 'px-8 py-2 bg-primary text-white rounded-xl' : ''">
        Outil de suivi
        </Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

</script>
