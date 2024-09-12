<template>
    <div class="overflow-hidden form-container px-2">

        <form :action="route(`${pluralize(resourceType)}.update`, item.id)" method="POST" enctype="multipart/form-data"
            name="form" id="form">

            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" :value="csrf">

            <div class="form-group md:grid grid-cols-2 gap-2">
                <div v-for="(value, attr) in fields" :key="attr"
                    :class="['mb-6', 'form-group', { 'col-span-2': value.colspan, 'required': value.required_on_edit }]">
                    <!-- Label and Input Fields based on the type -->
                    <label v-if="value.field !== 'checkbox'" :for="attr" class="mb-1 block font-semibold text-xs">
                        {{ value.title }}
                    </label>

                    <!-- model -->
                    <template v-if="value.field === 'model'">
                        <select :id="attr" :name="attr"
                            class=" outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs"
                            v-model="item[attr + '_id']">
                            <option value="">Sélectionner</option>
                            <option v-for="data in value.options" :key="data.id" :value="data.id"
                                :selected="item[attr + '_id'] == data.id">
                                {{ data.name || data.title }}
                            </option>
                        </select>
                    </template>

                    <!-- Select -->
                    <template v-else-if="value.field === 'select'">
                        <select v-model="item[attr]" :id="attr" :name="attr"
                            class=" outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs">
                            <option value="">Sélectionner</option>
                            <option v-for="(optValue, key) in value.options" :key="key" :value="key"
                                :selected="item[attr] == key">
                                {{ optValue }}
                            </option>
                        </select>
                    </template>

                    <!-- Multiple Select -->
                    <template v-else-if="value.field === 'multiple-select'">
                        <select v-model="item[attr]" :id="attr" :name="`${attr}[]`" multiple
                            class=" outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs">
                            <option v-for="data in value.options" :key="data.id" :value="data.id"
                                :selected="item[attr].includes(data.id)">
                                {{ data.name || data.title }}
                            </option>
                        </select>
                    </template>

                    <!-- Textarea / Richtext -->
                    <template v-else-if="value.field === 'textarea' || value.field === 'richtext'">
                        <textarea :id="attr" :name="attr" v-model="item[attr]"
                            class=" outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs"
                            :placeholder="value.title">{{ item[attr] }}</textarea>
                    </template>


                    <!-- File -->
                    <template v-else-if="value.field === 'file'">
                        <div class="rounded-lg bg-white p-2 text-xs">
                            <label :for="attr" class="">
                                <div class="flex items-center justify-between cursor-pointer text-gray-500 px-2">
                                    <div class="">Changez l'image</div>
                                    <div v-if="fileName" class="text-gray-500 px-2 border-l">{{ fileName }}</div>
                                    <div v-else class="text-gray-500 px-2 border-l">Aucune image</div>
                                </div>
                            </label>
                            <input v-show="false" :id="attr" :name="attr" type="file" accept="image/*"
                                @change="handleFileUpload($event, attr)" />
                        </div>
                        <div class="mt-3" v-if="filePreview">
                            <img :src="filePreview" alt="Prévisualisation de l'image" class="block h-24 rounded-lg" />
                        </div>
                        <div class="mt-3" v-else>
                            <img v-if="item[attr] !== null" :alt="item[attr]" class="block h-24 rounded-lg"
                                :src="`/storage/${item[attr]}`" />
                            <span v-else class="text-xs italic">Aucune image</span>
                        </div>
                    </template>

                    <!-- Checkbox -->
                    <template v-else-if="value.field === 'checkbox'">
                        <div class="flex items-center">
                            <input type="checkbox" :name="attr" :id="attr" :checked="item[attr] == 1"
                                v-model="item[attr]">
                            <label :for="attr" class="ml-3 text-xs">{{ value.title }}</label>
                        </div>
                    </template>

                    <!-- Checkbox -->
                    <template v-else-if="value.field === 'number'">
                        <input type="number" :id="attr" :name="item[attr]" :placeholder="value.placeholder || ''"
                            :step="value.step || 1"
                            class=" outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs placeholder:text-xs"
                            v-model="item[attr]" />
                    </template>

                    <!-- Dynamic Input Fields -->
                    <template v-else>
                        <input :id="attr" v-model="item[attr]" :name="attr" :type="value.field"
                            :placeholder="value.placeholder || ''"
                            class=" outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs placeholder:text-xs" />
                    </template>

                    <!-- Error Messages -->
                    <p v-if="errors[attr]" class="text-red-500 text-sm pl-2 pt-2">{{ errors[attr][0] }}</p>
                </div>
            </div>

            <div class="mt-4 flex gap-2 text-sm">
                <Link class="w-full bg-[#ddf3d1] py-2 rounded-lg font-bold text-center"
                    :href="route(`${pluralize(resourceType)}.index`)">
                Annuler
                </Link>

                <button type="submit" :disabled="isLoading"
                    class="w-full bg-primary py-2 rounded-lg text-white font-bold">
                    <span v-if="isLoading">Chargement...</span>
                    <span v-else>Modifier</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import pluralize from 'pluralize'
import { defineProps } from 'vue'
import { Link } from '@inertiajs/vue3';

// Props passed to the component
const props = defineProps({
    resourceType: {
        type: String,
        required: true,
    },
    fields: {
        type: Object,
        required: true,
    },
    item: {
        type: Object,
        required: true,
    },
    csrf: {
        type: String,
        required: true,
    }
})

const errors = ref([])
const isLoading = ref(false)
const fileName = ref(null)
const filePreview = ref(null)

const handleFileUpload = (event, attr) => {
    const file = event.target.files[0]
    if (file) {
        fileName.value = file.name;

        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            filePreview.value = reader.result; // Stocker l'URL de prévisualisation
        };
    }
}
</script>