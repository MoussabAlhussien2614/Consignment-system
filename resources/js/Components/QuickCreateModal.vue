<template>
  <Teleport to="body">
    <Transition name="modal">
      <div
        v-if="isOpen"
        class="fixed inset-0 z-50 overflow-y-auto"
        @click.self="close"
      >
        <div class="fixed inset-0 bg-black/50 transition-opacity" @click="close"></div>

        <div class="flex min-h-full items-center justify-center p-4">
          <div
            class="relative bg-white rounded-lg shadow-xl max-w-md w-full transform transition-all"
            @click.stop
          >
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
              <h3 class="text-lg font-semibold text-gray-900">{{ title }}</h3>
              <button
                @click="close"
                class="text-gray-400 hover:text-gray-600 transition-colors"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <form @submit.prevent="handleSubmit" class="p-6 space-y-4">
              <div
                v-for="field in fields"
                :key="field.name"
              >
                <FormInput
                  v-if="field.type !== 'select' && field.type !== 'textarea'"
                  :id="`modal-${field.name}`"
                  v-model="formData[field.name]"
                  :type="field.type || 'text'"
                  :label="field.label"
                  :placeholder="field.placeholder"
                  :required="field.required"
                  :error="errors[field.name]"
                />
                <FormSelect
                  v-else-if="field.type === 'select'"
                  :id="`modal-${field.name}`"
                  v-model="formData[field.name]"
                  :label="field.label"
                  :options="field.options || []"
                  :placeholder="field.placeholder"
                  :required="field.required"
                  :error="errors[field.name]"
                />
                <FormTextarea
                  v-else-if="field.type === 'textarea'"
                  :id="`modal-${field.name}`"
                  v-model="formData[field.name]"
                  :label="field.label"
                  :placeholder="field.placeholder"
                  :required="field.required"
                  :error="errors[field.name]"
                  :rows="field.rows || 3"
                />
              </div>

              <div v-if="generalError" class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                {{ generalError }}
              </div>

              <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button
                  type="button"
                  @click="close"
                  class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
                  :disabled="loading"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  :disabled="loading"
                  class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                >
                  <span v-if="loading">Creating...</span>
                  <span v-else>Create</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref, reactive, watch } from 'vue'
import axios from 'axios'
import FormInput from './FormInput.vue'
import FormSelect from './FormSelect.vue'
import FormTextarea from './FormTextarea.vue'

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },
  title: {
    type: String,
    required: true,
  },
  fields: {
    type: Array,
    required: true,
  },
  storeUrl: {
    type: String,
    required: true,
  },
  initialData: {
    type: Object,
    default: () => ({}),
  },
})

const emit = defineEmits(['close', 'created'])

const loading = ref(false)
const errors = reactive({})
const generalError = ref('')

const formData = reactive({})

watch(
  () => props.isOpen,
  (open) => {
    if (open) {
      Object.keys(formData).forEach((key) => {
        delete formData[key]
      })
      Object.keys(errors).forEach((key) => {
        delete errors[key]
      })
      generalError.value = ''

      props.fields.forEach((field) => {
        formData[field.name] = props.initialData[field.name] || field.default || ''
      })
    }
  },
  { immediate: true }
)

function close() {
  if (!loading.value) {
    emit('close')
  }
}

async function handleSubmit() {
  loading.value = true
  generalError.value = ''
  Object.keys(errors).forEach((key) => {
    delete errors[key]
  })

  try {
    const response = await axios.post(props.storeUrl, formData, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        Accept: 'application/json',
      },
    })

    emit('created', response.data)
    close()
  } catch (error) {
    if (error.response?.status === 422) {
      const validationErrors = error.response.data.errors || {}
      Object.keys(validationErrors).forEach((key) => {
        errors[key] = Array.isArray(validationErrors[key])
          ? validationErrors[key][0]
          : validationErrors[key]
      })
    } else {
      generalError.value =
        error.response?.data?.message || 'An error occurred while creating the item.'
    }
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-active .bg-white,
.modal-leave-active .bg-white {
  transition: transform 0.3s ease, opacity 0.3s ease;
}

.modal-enter-from .bg-white,
.modal-leave-to .bg-white {
  transform: scale(0.95);
  opacity: 0;
}
</style>

