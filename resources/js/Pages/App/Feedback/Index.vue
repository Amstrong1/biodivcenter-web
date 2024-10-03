<template>

    <Head title="Feedbacks" />
    <AuthenticatedLayout>
        <Navigation />
        <span class="font-bold">Feedback Utilisateurs</span>

        <div class="w-full flex flex-col mb-10 md:mb-0">
            <div class="md:col-span-5">
                <ElementsTable :csrf="$page.props.csrf" :resources="$page.props.feedbacks"
                    :mattributes="$page.props.my_attributes" :mactions="$page.props.my_actions" :type="'feedback'" />
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
</script>
