<template>
  <div>
    <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700 mb-2">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    <div class="relative">
      <div v-if="icon" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
        <component :is="icon" class="h-5 w-5 text-gray-400" />
      </div>
      <select
        :id="id"
        :value="stringValue(modelValue)"
        @change="onChange"
        :required="required"
        :disabled="disabled"
        :class="[
          'block w-full py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white text-gray-900',
          icon ? 'pl-10' : 'pl-3',
          error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '',
          disabled ? 'opacity-50 cursor-not-allowed' : '',
        ]"
      >
        <option v-if="placeholder" value="">{{ placeholder }}</option>
        <option
          v-for="option in options"
          :key="option.value + '-' + option.label"
          :value="String(option.value)"
        >
          {{ option.label }}
        </option>
      </select>
    </div>
    <transition name="fade">
      <p v-if="error" class="mt-2 text-sm text-red-600 flex items-center gap-1">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        {{ error }}
      </p>
    </transition>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  id: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    default: '',
  },
  modelValue: {
    type: [String, Number, null],
    default: '',
  },
  options: {
    type: Array,
    required: true,
  },
  placeholder: {
    type: String,
    default: '',
  },
  required: {
    type: Boolean,
    default: false,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  error: {
    type: String,
    default: '',
  },
  icon: {
    type: Object,
    default: null,
  },
})

const emit = defineEmits(['update:modelValue', 'change', 'add-new'])

function stringValue(val) {
  if (val === null || val === undefined) return ''
  return String(val)
}

const previousValue = ref(props.modelValue || '')

watch(() => props.modelValue, (newVal) => {
  if (newVal && String(newVal).startsWith('add_new_')) {
    return 
  }
  previousValue.value = newVal || ''
})

function onChange(event) {
  const selectedString = event.target.value

  if (selectedString === '') {
    emit('update:modelValue', '')
    emit('change', '')
    return
  }

  if (selectedString.startsWith('add_new_')) {
    event.target.value = stringValue(previousValue.value)
    emit('add-new', selectedString.replace('add_new_', ''))
    return
  }

  const found = props.options.find(opt => String(opt.value) === selectedString)

  if (found !== undefined) {
    previousValue.value = found.value
    emit('update:modelValue', found.value)
    emit('change', found.value)
  } else {
    previousValue.value = selectedString
    emit('update:modelValue', selectedString)
    emit('change', selectedString)
  }
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
