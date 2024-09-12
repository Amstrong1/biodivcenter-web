<template>

    <Head title="Ordres" />
    <AuthenticatedLayout>

        <div class="py-12">
            <div class="md:w-3/4 lg:w-2/3 mx-auto sm:px-6 lg:px-8">
                <div class="bg-[#f1f4ef] overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-10">
                        <span class="font-bold">Modifier ordre</span>
                        <hr class="mt-2 mb-6 h-1 bg-black rounded-lg">
                        <FormEdit :item="$page.props.order" :fields="$page.props.my_fields" :csrf="$page.props.csrf"
                            resourceType="order" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import FormEdit from '@/Components/Form/Edit.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>