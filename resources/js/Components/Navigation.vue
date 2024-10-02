<template>
    <div class="flex justify-start items-center bg-[#f1f4ef] rounded-xl py-2 px-4 text-xs gap-8 w-auto mb-4">

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

        <Link :href="route('reproductions.index')" v-if="$page.props.auth.user.role == 'adminONG'"
            :class="route().current('reproductions.index') ? 'px-8 py-2 bg-primary text-white rounded-xl' : ''">
        Historique Reproductions
        </Link>

        <Link :href="route('sanitary-states.index')" v-if="$page.props.auth.user.role == 'adminONG'"
            :class="route().current('sanitary-states.index') ? 'px-8 py-2 bg-primary text-white rounded-xl' : ''">
        Historique Etat Sanitaire
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
