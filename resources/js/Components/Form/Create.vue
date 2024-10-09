<template class="mb-4">
    <div class="w-full p-2 overflow-hidden">
        <form @submit.prevent="submit" method="POST" enctype="multipart/form-data" name="form" id="form"
            class="text-sm">

            <div class="form-group md:grid grid-cols-2 gap-x-4">
                <div v-for="(value, attr) in fields" :key="attr" :class="{
                    'hidden': value.hidden,
                    'form-group': true,
                    'required': value.required,
                    'col-span-2': value.colspan
                }">

                    <!-- Label and Input Fields based on the type -->
                    <label v-if="value.field !== 'checkbox'" :for="attr" class="mb-1 block font-semibold text-xs">
                        {{ value.title }}
                        <span class="text-red-500" v-if="value.required">*</span>
                    </label>

                    <!-- model -->
                    <div class="mb-4" v-if="value.field === 'model'">
                        <select :id="attr" :name="attr"
                            class="outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs"
                            v-model="form[attr]">
                            <option value="" disabled>Cliquer pour sélectionner</option>
                            <option v-for="item in value.options" :key="item.id" :value="item.id">
                                {{ item.name || item.title }}
                            </option>
                        </select>
                    </div>

                    <!-- model optgroup -->
                    <div class="mb-4" v-else-if="value.field === 'model-optgroup'">
                        <select :id="attr" :name="attr"
                            class="outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs"
                            v-model="form[attr]">
                            <option value="" disabled>Cliquer pour sélectionner</option>
                            <optgroup v-for="(group, index) in value.options" :key="index" :label="group.label">
                                <option v-for="item in group.options" :key="item.id" :value="item.id">
                                    {{ item.name || item.title }}
                                </option>
                            </optgroup>
                        </select>
                    </div>

                    <!-- Select -->
                    <div class="mb-4" v-else-if="value.field === 'select'">
                        <select :id="attr" :name="attr"
                            class="outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs"
                            v-model="form[attr]">
                            <option value="" disabled>Cliquer pour sélectionner</option>
                            <option v-for="(optionValue, key) in value.options" :key="key" :value="key">
                                {{ optionValue }}
                            </option>
                        </select>
                    </div>

                    <!-- Multiple Select -->
                    <div class="mb-4" v-else-if="value.field === 'multiple-select'">
                        <select :id="attr" :name="`${attr}[]`"
                            class="outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs"
                            multiple v-model="form[attr]">
                            <option value="" disabled>Cliquer pour sélectionner</option>
                            <option v-for="item in value.options" :key="item.id" :value="item.id">
                                {{ item.name || item.title }}
                            </option>
                        </select>
                    </div>

                    <!-- Textarea / Richtext -->
                    <div class="mb-4" v-else-if="value.field === 'textarea' || value.field === 'richtext'">
                        <textarea :id="attr" :name="attr" :placeholder="value.placeholder || ''"
                            class="outline-none focus:ring-0 focus:border-0 focus:ring-offset-0 block w-full rounded-lg border-0 text-xs"
                            v-model="form[attr]"></textarea>
                    </div>

                    <!-- File -->
                    <div class="mb-4" v-else-if="value.field === 'file'">
                        <div class="rounded-lg bg-white p-2">
                            <label :for="attr" class="">
                                <div class="flex items-center justify-between cursor-pointer text-xs px-2">
                                    <div class="text-gray-500">Sélectionnez une image</div>
                                    <div v-if="fileName" class="text-gray-500 px-2 border-l">{{ fileName }}</div>
                                    <div v-else class="text-gray-500 px-2 border-l">Aucune image</div>
                                </div>
                            </label>
                            <input v-show="false" type="file" :id="attr" :name="attr" accept="image/*"
                                @change="handleFileUpload($event, attr)" />
                        </div>
                        <div class="mt-3" v-if="filePreview">
                            <img :src="filePreview" alt="Prévisualisation de l'image" class="block h-24 rounded-lg" />
                        </div>
                    </div>

                    <!-- checkbox -->
                    <div v-else-if="value.field === 'checkbox'">
                        <div v-if="value.displayValue == null || Object.keys(form).some(key => key === value.watcher && form[key] === value.displayValue)"
                            class="flex items-center mb-4">
                            <input type="checkbox" :id="attr" :name="attr" v-model="form[attr]" />
                            <label :for="attr" class="ml-2 text-xs">{{ value.title }}</label>
                        </div>
                    </div>

                    <!-- number -->
                    <div class="mb-4" v-else-if="value.field === 'number'">
                        <input type="number" :id="attr" :name="attr" :placeholder="value.placeholder || ''"
                            :step="value.step || 1"
                            class="block w-full rounded-lg border-0 placeholder:text-xs text-xs outline-none focus:ring-0 focus:border-0 focus:ring-offset-0"
                            v-model="form[attr]" />
                    </div>

                    <!-- Dynamic Input Fields -->
                    <div class="mb-4" v-else>
                        <div v-if="!value.hidden">
                            <input :type="value.field" :id="attr" :name="attr" :placeholder="value.placeholder || ''"
                                class="block w-full rounded-lg border-0 placeholder:text-xs text-xs outline-none focus:ring-0 focus:border-0 focus:ring-offset-0"
                                v-model="form[attr]" />
                        </div>
                        <div v-else>
                            <input :value="value.value" :id="attr" :name="attr" type="hidden" />
                        </div>
                    </div>

                    <p v-if="$page.props.errors[attr]" class="text-red-500 text-xs mb-2 -mt-2">
                        {{ $page.props.errors[attr] }}
                    </p>
                </div>
            </div>

            <div class="mt-4 flex gap-2">
                <button type="button" @click="closeModal" class="w-full bg-[#ddf3d1] py-2 rounded-lg font-bold text-xs">
                    Annuler
                </button>

                <button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    class="w-full bg-primary py-2 rounded-lg text-white font-bold text-xs">
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import pluralize from 'pluralize'
import { defineProps } from 'vue'
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    resourceType: {
        type: String,
        required: true,
    },
    fields: {
        type: Object,
        required: true,
    }
})

const form = ref({})
const emit = defineEmits(['formClosed'])

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

const submit = async () => {

    const formData = useForm(form.value)

    formData.post(route(`${pluralize(props.resourceType)}.store`), {
        onSuccess: () => {
            Object.keys(form.value).forEach(key => {
                form.value[key] = null
            })

            fileName.value = null
            filePreview.value = null
            emit('formClosed')
        },
    })
}

const closeModal = () => {
    emit('formClosed')
}
</script>
