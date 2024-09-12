<template>
    <div class="py-12">
        <div class="md:w-3/4 lg:w-2/3 mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#f1f4ef] overflow-hidden shadow-lg sm:rounded-lg p-10">
                <span class="font-bold">Modifier type d'habitat</span>
                <hr class="mt-2 mb-6 h-1 bg-black rounded-lg">
                <FormsShow :item="typeHabitat" :fields="myFields" resourceType="type-habitat" />
            </div>
        </div>
    </div>
</template>

<script setup>
import FormsShow from '../../components/Forms/Show.vue'
import { ref, onMounted } from 'vue'
import { useRoute } from "vue-router"

const router = useRoute()

const typeHabitat = ref([])
const myFields = ref({})

const gettypeHabitat = async () => {
    await axios.get(`/api/type-habitats/${router.params.id}`).then(response => {
        const { typeHabitat: restypeHabitat, my_fields: resFields } = response.data
        typeHabitat.value = restypeHabitat
        myFields.value = resFields
    })
}

onMounted(async () => {
    await gettypeHabitat()
})
</script>