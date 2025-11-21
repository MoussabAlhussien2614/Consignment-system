<template>
  <Navbar :user="user">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <div>
          <Link :href="route('consignments.index')" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Consignments
          </Link>
          <h1 class="text-3xl font-bold text-gray-900">Edit Consignment</h1>
          <p class="text-gray-600 mt-1">Update consignment information</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <form @submit.prevent="submit" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <FormInput
                    :id="`item-name`"
                    v-model="form.name"
                    label="Item Name"
                    placeholder="Enter item name"
                    :error="getError('name')"
                    required
                />

                <FormInput
                    :id="`item-sku`"
                    v-model="form.sku"
                    label="SKU"
                    placeholder="Enter SKU (optional)"
                    :error="getError('sku')"
                />

                <FormSelect
                    :id="`item-category_id`"
                    v-model="form.category_id"
                    label="Category"
                    :options="categoryOptions"
                    placeholder="Select category"
                    :error="getError('category_id')"
                    required
                    @add-new="handleAddNewCategory"
                />

                <FormInput
                    :id="`item-quantity`"
                    v-model.number="form.quantity"
                    type="number"
                    label="Quantity"
                    placeholder="Enter quantity"
                    :error="getError('quantity')"
                    required
                />

                <FormInput
                    :id="`item-unit_price`"
                    v-model.number="form.unit_price"
                    type="number"
                    step="0.01"
                    label="Unit Price"
                    placeholder="0.00"
                    :error="getError('unit_price')"
                    required
                />

                <FormInput
                    :id="`item-extra_expences`"
                    v-model.number="form.extra_expences"
                    type="number"
                    step="0.01"
                    label="Extra Expenses"
                    placeholder="0.00"
                    :error="getError('extra_expences')"
                />

                <FormInput
                    :id="`item-commission_rate`"
                    v-model.number="form.commission_rate"
                    type="number"
                    label="Commission Rate (%)"
                    placeholder="0"
                    :error="getError('commission_rate')"
                    required
                />
                </div>

                <FormTextarea
                :id="`item-notes`"
                v-model="form.notes"
                label="Notes"
                placeholder="Additional notes (optional)"
                :error="getError('notes')"
                :rows="2"
                />
            <div class="flex justify-end gap-4 pt-4">
              <Link
                :href="route('consignments.index')"
                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
              >
                Cancel
              </Link>
              <button
                type="submit"
                class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
              >
                <span >Update Consignment</span>
              </button>
            </div>
          </form>
        </div>
      </div>

  
    </div>
  </Navbar>
</template>

<script setup>
import {  Link, useForm } from '@inertiajs/vue3'
import Navbar from '../Navbar.vue'
import FormInput from '../../Components/FormInput.vue'
import FormTextarea from '../../Components/FormTextarea.vue'
import FormSelect from '../../Components/FormSelect.vue'
import { route } from '../../helpers/route.js'
import { computed } from 'vue'


const props = defineProps({
  consignment_item: {
    type: Object,
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

})

function submit() {
  form.put(route('consignment-items.update', { id: props.consignment_item.id }))
}

const emit = defineEmits(['update:consignment_item', 'remove', 'open-add-category-modal'])


const form = useForm({
    name: props.consignment_item.name  || '',
    sku: props.consignment_item.sku  || '',
    category_id: props.consignment_item.category_id  || '',
    quantity: props.consignment_item.quantity  || '',
    unit_price: props.consignment_item.unit_price  || '',
    extra_expences: props.consignment_item.extra_expences  || '',
    commission_rate: props.consignment_item.commission_rate  || '',
    notes: props.consignment_item.notes  || '',
})

const categoryOptions = computed(() => {
  const base = props.categories.map(c => ({ value: c.id, label: c.name }))
  base.push({ value: 'add_new_category', label: '+ Add New Category' })
  return base
})

function handleAddNewCategory() {
  emit('open-add-category-modal', { index: props.index })
}

function getError(field) {
  const errorKey = `items.${props.index}.${field}`
  return props.errors[errorKey] || ''
}


</script>

<style scoped>
</style>

