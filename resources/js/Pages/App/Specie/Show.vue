<template>
    <div class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-[#f1f4ef] overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-10">
                    <span class="font-bold">Espèce Détail</span>
                    <hr class="mt-2 mb-6 h-1 bg-black rounded-lg">
                    <FormsShow :item="specie" :fields="myFields" resourceType="specie" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import FormsShow from '../../components/Forms/Show.vue'
import axios from 'axios'
import { ref, onMounted } from 'vue'
import { useRoute } from "vue-router"

const router = useRoute()

const specie = ref([])
const myFields = ref({})

const getSpecie = async () => {
    await axios.get(`/api/species/${router.params.id}`).then(response => {
        const { specie: resSpecie, my_fields: resFields } = response.data
        specie.value = resSpecie
        myFields.value = resFields
    })
}

onMounted(async () => {
    await getSpecie()
})
</script>