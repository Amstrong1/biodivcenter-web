<template>
    <div class="flex flex-col items-stretch w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <div class="flex justify-center items-center p-4 table-search-container w-full">
                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-800" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="custom-search-input" v-model="filter"
                        class="border-0 block p-2 pl-10 w-80 form-input placeholder:text-gray-800 bg-[#f1f4ef] rounded-lg text-xs"
                        placeholder="Rechercher dans la liste">
                </div>
            </div>

            <div class="p-6 bg-[#f1f4ef] rounded-lg overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="tracking-wide text-left text-sm bg-[#ddf3d1]">
                            <th v-for="(title, column) in mattributes" :key="column" class="px-4 py-3">
                                {{ title }}
                            </th>
                            <th v-if="mactions && mactions.edit || mactions && mactions.delete" class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-if="resources.data.length === 0" class="border-b border-slate-500">
                            <td :colspan="Object.keys(mattributes).length + 1"
                                class="px-6 py-4 whitespace-nowrap text-center text-xs">
                                Aucun Element
                            </td>
                        </tr>

                        <tr v-for="resource in resources.data" class="">
                            <td v-for="(title, column) in mattributes" :key="column" class="px-4 py-3 text-xs">
                                <template v-if="column === 'logo' || column === 'picture' || column === 'photo'">
                                    <a class="flex items-center justify-center text-sm hover:opacity-80">
                                        <div class="relative hidden h-12 w-12 mr-3 md:block">
                                            <img v-if="resource[column] !== null"
                                                class="object-cover w-full h-full rounded-lg"
                                                :src="'/storage/' + resource[column]" alt="profile" loading="lazy" />

                                            <img v-else class="object-cover w-full h-full rounded-lg"
                                                src="/assets/icon/user.png" alt="profile" loading="lazy" />
                                        </div>
                                    </a>
                                </template>
                                <template v-else-if="column === 'name' || column === 'title' || column === 'label'">
                                    <Link v-if="mactions && mactions.show"
                                        :href="route(`${pluralize(type)}.show`, resource.id)"
                                        class="w-12 p-2 rounded-full text-xs bg-[#ddf3d1] text-primary text-center font-semibold whitespace-nowrap">
                                    {{ resource[column] }}
                                    </Link>
                                    <span v-else>
                                        {{ resource[column] }}
                                    </span>
                                </template>
                                <template v-else-if="column === 'status'">
                                    <span :class="[
                                        'whitespace-nowrap px-2 py-1 font-semibold leading-tight rounded-full',
                                        resource[column] === 'Terminé' ?
                                            'text-primary bg-[#ddf3d1]' :
                                            resource[column] === 'En cours' ?
                                                'text-gray-700 bg-gray-100' :
                                                'text-gray-700 bg-yellow-100'
                                    ]">
                                        {{ resource[column] }}
                                    </span>
                                </template>
                                <template v-else>
                                    <!-- <span v-if="isString(resource[column]) && resource[column].length > 100">
                                        {{ truncate(resource[column], 100) }}
                                    </span> -->
                                    <span>
                                        {{ resource[column] }}
                                    </span>
                                </template>
                            </td>

                            <td v-if="mactions && mactions.edit || mactions && mactions.delete" class="px-4 py-3">
                                <div class="flex items-center justify-start space-x-4">
                                    <Link v-if="mactions.edit" :href="route(`${pluralize(type)}.edit`, resource.id)"
                                        class="w-14 p-2 rounded-full text-xs bg-yellow-200 text-yellow-500 text-center font-semibold"
                                        aria-label="Edit">
                                    Editer
                                    </Link>
                                    <button v-if="mactions.delete" @click="deleteResource(resource.id)"
                                        class="w-12 p-2 text-xs bg-red-200 text-red-600 rounded-full text-center font-semibold"
                                        aria-label="Delete">
                                        Sup
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Pagination Links -->
                <Pagination :links="resources.links" :current="resources.to" :total="resources.total" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { truncate, isString } from "lodash";
import { Link, usePage, router, useForm } from '@inertiajs/vue3';
import pluralize from "pluralize";
import { defineProps, ref, watch } from 'vue'
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    resources: {
        type: Object,
        required: true
    },
    mattributes: {
        type: Object,
        required: true
    },
    mactions: {
        type: Object,
    },
    type: {
        type: String,
        required: true
    },
    csrf: {
        type: String,
        required: true
    }
})

const form = useForm({});

const deleteResource = (id) => {
    if (typeof swal !== "undefined") {
        swal({
            title: "Suppression",
            text: "Cet élément sera supprimé",
            dangerMode: true,
            icon: "warning",
            buttons: {
                cancel: true,
                confirm: "Oui, Supprimer",
            },
            cancel: true,
        }).then((value) => {
            if (value) {
                form.delete(`${pluralize(props.type)}/${id}`);
            } else {
                swal("Suppression annulée", {
                    timer: 2000,
                });
            }
        });
    } else {
        const value = confirm("Voulez vous supprimer cet élément ?");
        if (value) {
            form.delete(`${pluralize(props.type)}/${id}`);
        }
    }
};

const filter = ref(null);

if (usePage().props.filters?.search) {
    filter.value = usePage().props.filters.search;
}

watch(filter, (newFilter) => {
    router.get(route(`${pluralize(props.type)}.index`), { search: newFilter }, { preserveState: true, replace: true });
});

</script>
