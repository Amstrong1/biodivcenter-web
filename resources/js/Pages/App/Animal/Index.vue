<template>

    <Head title="Individus" />
    <AuthenticatedLayout>
        <Navigation/>
        <div>
            <div class="flex justify-between items-center">
                <span class="font-bold">Liste des individus</span>
            </div>
        </div>

        <div class="w-full flex flex-col mb-10 md:mb-0">
            <div class="md:col-span-5">
                <ElementsTable :csrf="$page.props.csrf" :resources="$page.props.animals"
                    :mattributes="$page.props.my_attributes" :mactions="$page.props.my_actions" :type="'animal'" />
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<script setup>
import { ref } from 'vue'
import ElementsTable from '@/Components/Table.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Navigation from '@/Components/Navigation.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const showModal = ref(false);

const closeModal = () => {
    showModal.value = false
}
</script>
