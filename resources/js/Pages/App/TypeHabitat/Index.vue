<template>

    <Head title="Type d'habitat" />
    <AuthenticatedLayout>
        <Navigation />
        <div>
            <div class="flex justify-between items-center">
                <span class="font-bold">Liste des types d'habitat</span>
                <PrimaryButton @click="showModal = true">
                    <img src="/assets/icon/add.png" alt="">
                    Ajouter
                </PrimaryButton>
            </div>
        </div>

        <div class="w-full flex flex-col mb-10 md:mb-0">
            <div class="md:col-span-5">
                <ElementsTable :csrf="$page.props.csrf" :resources="$page.props.typeHabitats"
                    :mattributes="$page.props.my_attributes" :mactions="$page.props.my_actions"
                    :type="'type-habitat'" />
            </div>
        </div>

        <Teleport to="body">
            <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0"
                enter-to-class="opacity-100" leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div v-show="showModal"
                    class="fixed inset-0 bg-white bg-opacity-25 backdrop-blur-sm flex items-center justify-center z-50">
                    <div class="bg-[#f1f4ef] rounded-lg p-10 max-h-[80vh] overflow-auto" style="width: 500px">
                        <span class="font-bold">Ajouter type habitat</span>
                        <hr class="mt-2 mb-6 h-1 bg-black rounded-lg">
                        <FormCreate @formClosed="closeModal" :fields="$page.props.my_fields" resourceType="type-habitat"
                            :csrf="$page.props.csrf" />

                        <div class="mt-8">
                            <form @submit.prevent="submitFileForm" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" :value="$page.props.csrf" />
                                <span class="font-semibold text-xs">Importer des types d'habitat</span>
                                <div class="rounded-lg bg-white p-2">
                                    <label for="file">
                                        <div class="flex items-center justify-between cursor-pointer text-xs px-2">
                                            <div class="text-gray-500">Sélectionnez un fichier Excel</div>
                                            <div v-if="fileName" class="text-gray-500 px-2 border-l">
                                                {{ fileName }}
                                            </div>
                                            <div v-else class="text-gray-500 px-2 border-l">Aucun fichier</div>
                                        </div>
                                    </label>
                                    <input v-show="false" type="file" id="file" name="file" accept="*.xlsx, *.xls"
                                        @change="fileUpload($event)" />
                                </div>

                                <PrimaryButton class="text-xs font-semibold mt-2" type="submit">
                                    Importer
                                </PrimaryButton>
                            </form>
                        </div>
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
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const showModal = ref(false);

const closeModal = () => {
    showModal.value = false
}

const formFile = useForm({
    file: '',
})

const fileName = ref('')

const submitFileForm = async () => {

formFile.post(route('type-habitats.import'), {
    onSuccess: () => {

        fileName.value = null
        showModal.value = false
    },
})
}

const fileUpload = (event) => {
    formFile.file = event.target.files[0]
    fileName.value = event.target.files[0].name
}
</script>
