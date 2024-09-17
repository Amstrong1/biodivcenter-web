<template>
    <div class="overflow-hidden form-container px-2">

        <form @submit.prevent="updateResource" enctype="multipart/form-data" name="form" id="form">

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
                            v-model="form[attr + '_id']">
                            <option value="">Sélectionner</option>
                            <option v-for="data in value.options" :key="data.id" :value="data.id"
                                :selected="form[attr + '_id'] == data.id">
                                {{ data.name || data.title }}
                            </option>
                        </select>
                    </template>

                    <!-- Select -->
                    <template v-else-if="value.field === 'select'">
                        <select v-model="form[attr]" :id="attr" :name="attr"
                            class=" outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs">
                            <option value="">Sélectionner</option>
                            <option v-for="(optValue, key) in value.options" :key="key" :value="key"
                                :selected="form[attr] == key">
                                {{ optValue }}
                            </option>
                        </select>
                    </template>

                    <!-- Multiple Select -->
                    <template v-else-if="value.field === 'multiple-select'">
                        <select v-model="form[attr]" :id="attr" :name="`${attr}[]`" multiple
                            class=" outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs">
                            <option v-for="data in value.options" :key="data.id" :value="data.id"
                                :selected="form[attr].includes(data.id)">
                                {{ data.name || data.title }}
                            </option>
                        </select>
                    </template>

                    <!-- Textarea / Richtext -->
                    <template v-else-if="value.field === 'textarea' || value.field === 'richtext'">
                        <textarea :id="attr" :name="attr" v-model="form[attr]"
                            class=" outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs"
                            :placeholder="value.title">{{ form[attr] }}</textarea>
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
                            <img v-if="form[attr] !== null" :alt="form[attr]" class="block h-24 rounded-lg"
                                :src="`/storage/${form[attr]}`" />
                            <span v-else class="text-xs italic">Aucune image</span>
                        </div>
                    </template>

                    <!-- Checkbox -->
                    <template v-else-if="value.field === 'checkbox'">
                        <div class="flex items-center">
                            <input type="checkbox" :name="attr" :id="attr" :checked="form[attr] == 1"
                                v-model="form[attr]">
                            <label :for="attr" class="ml-3 text-xs">{{ value.title }}</label>
                        </div>
                    </template>

                    <!-- Checkbox -->
                    <template v-else-if="value.field === 'number'">
                        <input type="number" :id="attr" :name="form[attr]" :placeholder="value.placeholder || ''"
                            :step="value.step || 1"
                            class=" outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs placeholder:text-xs"
                            v-model="form[attr]" />
                    </template>

                    <!-- Dynamic Input Fields -->
                    <template v-else>
                        <input :id="attr" v-model="form[attr]" :name="attr" :type="value.field"
                            :placeholder="value.placeholder || ''"
                            class=" outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs placeholder:text-xs" />
                    </template>

                    <!-- Error Messages -->
                    <p v-if="$page.props.errors[attr]" class="text-red-500 text-xs pl-2 pt-2">
                        {{ $page.props.errors[attr] }} 
                    </p>
                </div>
            </div>

            <div class="mt-4 flex gap-2 text-sm">
                <Link class="w-full bg-[#ddf3d1] py-2 rounded-lg font-bold text-center"
                    :href="route(`${pluralize(resourceType)}.index`)">
                Annuler
                </Link>

                <button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="w-full bg-primary py-2 rounded-lg text-white font-bold">
                   Modifier
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import pluralize from 'pluralize'
import { defineProps } from 'vue'
import { Link, useForm } from '@inertiajs/vue3';

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

const form = ref({})

form.value = { ...props.item }

const fileName = ref(null)
const filePreview = ref(null)

const handleFileUpload = (event, attr) => {
    const file = event.target.files[0]
    form.value[attr] = file
    if (file) {
        fileName.value = file.name;

        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            filePreview.value = reader.result; // Stocker l'URL de prévisualisation
        };
    }
}

const updateResource = () => {
    const formData = useForm(form.value)

    formData.put(route(`${pluralize(props.resourceType)}.update`, props.item.id))

    fileName.value = null
    filePreview.value = null
};
</script>