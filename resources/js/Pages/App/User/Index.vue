<template>

    <Head title="Utilisateurs" />
    <AuthenticatedLayout>
        <div>
            <div class="flex justify-between items-center">
                <span class="font-bold">Liste des utilisateurs</span>
                <PrimaryButton @click="showModal = true"> 
                    <img src="/assets/icon/add.png" alt="">
                    Ajouter
                </PrimaryButton>
            </div>
        </div>

        <div class="w-full flex flex-col mb-10 md:mb-0">
            <div class="md:col-span-5">
                <ElementsTable :csrf="$page.props.csrf" :resources="$page.props.users"
                    :mattributes="$page.props.my_attributes" :mactions="$page.props.my_actions" :type="'user'" />
            </div>
        </div>

        <Teleport to="body">
            <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0"
                enter-to-class="opacity-100" leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div v-show="showModal"
                    class="fixed inset-0 bg-white bg-opacity-25 backdrop-blur-sm flex items-center justify-center z-50">
                    <div class="bg-[#f1f4ef] rounded-lg p-10 max-h-[80vh] overflow-auto" style="width: 500px">
                        <span class="font-bold">Ajouter utilisateur</span>
                        <hr class="mt-2 mb-6 h-1 bg-black rounded-lg">
                        <FormCreate @formClosed="closeModal" :fields="$page.props.my_fields" resourceType="user"
                            :csrf="$page.props.csrf" />
                    </div>
                </div>
            </transition>
        </Teleport>
    </AuthenticatedLayout>

</template>

<script setup>
import { ref } from 'vue'
import ElementsTable from '@/Components/Table.vue'
import FormCreate from '@/Components/Form/Create.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Navigation from '@/Components/Navigation.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const showModal = ref(false);

const closeModal = () => {
    showModal.value = false
}
</script>
