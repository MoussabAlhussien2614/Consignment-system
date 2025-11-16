<template>
  <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 space-y-4">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-semibold text-gray-900">Item {{ index + 1 }}</h3>
      <button
        v-if="removable"
        type="button"
        @click="$emit('remove')"
        class="text-red-600 hover:text-red-800 transition-colors"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
      </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <FormInput
        :id="`item-${index}-name`"
        v-model="itemData.name"
        label="Item Name"
        placeholder="Enter item name"
        :error="getError('name')"
        required
      />

      <FormInput
        :id="`item-${index}-sku`"
        v-model="itemData.sku"
        label="SKU"
        placeholder="Enter SKU (optional)"
        :error="getError('sku')"
      />

      <FormSelect
        :id="`item-${index}-category_id`"
        v-model="itemData.category_id"
        label="Category"
        :options="categoryOptions"
        placeholder="Select category"
        :error="getError('category_id')"
        required
      />

      <FormInput
        :id="`item-${index}-quantity`"
        v-model.number="itemData.quantity"
        type="number"
        label="Quantity"
        placeholder="Enter quantity"
        :error="getError('quantity')"
        required
      />

      <FormInput
        :id="`item-${index}-unit_price`"
        v-model.number="itemData.unit_price"
        type="number"
        step="0.01"
        label="Unit Price"
        placeholder="0.00"
        :error="getError('unit_price')"
        required
      />

      <FormInput
        :id="`item-${index}-extra_expences`"
        v-model.number="itemData.extra_expences"
        type="number"
        step="0.01"
        label="Extra Expenses"
        placeholder="0.00"
        :error="getError('extra_expences')"
      />

      <FormInput
        :id="`item-${index}-commission_rate`"
        v-model.number="itemData.commission_rate"
        type="number"
        label="Commission Rate (%)"
        placeholder="0"
        :error="getError('commission_rate')"
        required
      />
    </div>

    <FormTextarea
      :id="`item-${index}-notes`"
      v-model="itemData.notes"
      label="Notes"
      placeholder="Additional notes (optional)"
      :error="getError('notes')"
      :rows="2"
    />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import FormInput from '../FormInput.vue'
import FormSelect from '../FormSelect.vue'
import FormTextarea from '../FormTextarea.vue'

const props = defineProps({
  modelValue: {
    type: Object,
    required: true,
  },
  index: {
    type: Number,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
  errors: {
    type: Object,
    default: () => ({}),
  },
  removable: {
    type: Boolean,
    default: true,
  },
})

const emit = defineEmits(['update:modelValue', 'remove'])

const itemData = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
})

const categoryOptions = computed(() => {
  return props.categories.map(category => ({
    value: category.id,
    label: category.name,
  }))
})

function getError(field) {
  const errorKey = `items.${props.index}.${field}`
  return props.errors[errorKey] || ''
}
</script>

<style scoped>
</style>

