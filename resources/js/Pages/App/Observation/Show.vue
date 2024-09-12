<template>
    <div class="py-12">
        <div class="md:w-3/4 lg:w-2/3 mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#f1f4ef] overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-10">
                    <span class="font-bold">Observation Détail</span>
                    <hr class="mt-2 mb-6 h-1 bg-black rounded-lg">
                    <FormsShow :item="observation" :fields="myFields" resourceType="observation" />
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

const observation = ref([])
const myFields = ref({})

const getObservation = async () => {
    await axios.get(`/api/observations/${router.params.id}`).then(response => {
        const { observation: resObservation, my_fields: resFields } = response.data
        observation.value = resObservation
        myFields.value = resFields
    })
}

onMounted(async () => {
    await getObservation()
})
</script>