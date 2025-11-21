<template>
  <Navbar :user="user">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <div>
          <Link :href="route('sales.index')" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Sales
          </Link>
          <h1 class="text-3xl font-bold text-gray-900">Edit Sale</h1>
          <p class="text-gray-600 mt-1">Update Sale information</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <form @submit.prevent="submit" class="space-y-5">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Consignment Item</label>
              <SaleItemSelector :items="props.items" :vendors="props.vendors" :vehicles="props.vehicles" @selected="onItemSelected" />
              <input type="hidden" v-model="form.item_id" />
              <p v-if="form.errors.item_id" class="mt-2 text-sm text-red-600">{{ form.errors.item_id }}</p>

              <div v-if="selectedItem" class="mt-3 p-3 bg-gray-50 rounded border">
                <div class="text-sm text-gray-600">Selected: <strong class="text-gray-900">{{ selectedItem.name }}</strong></div>
                <div class="text-sm text-gray-600">Unit Price: <strong class="text-gray-900">{{ Number(selectedItem.unit_price || 0).toFixed(2) }}</strong></div>
                <div class="text-sm text-gray-600">Available: <strong class="text-gray-900">{{ selectedItem.quantity_available ?? 0 }}</strong></div>
              </div>
            </div>

            <FormInput
              id="quantity"
              v-model.number="form.quantity"
              type="number"
              label="Quantity"
              placeholder="Enter quantity"
              :error="form.errors.quantity"
              required
            />
            <p v-if="qtyTooHigh" class="text-sm text-red-600">Quantity exceeds available stock.</p>

              <FormInput
                id="price"
                v-model.number="form.price"
                type="number"
                step="0.01"
                label="Price"
                placeholder="0.00"
                :error="form.errors.price"
              />
              <p v-if="priceTooLow" class="text-sm text-red-600">Price cannot be less than unit price.</p>

            <div class="flex justify-end gap-4 pt-4">
              <Link
                :href="route('sales.index')"
                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
              >
                Cancel
              </Link>
              <button
                type="submit"
                :disabled="form.processing || !canSubmit"
                class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
              >
                <span v-if="form.processing">Updating...</span>
                <span v-else>Update Sale</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </Navbar>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import Navbar from '../Navbar.vue'
import FormInput from '../../Components/FormInput.vue'
import FormTextarea from '../../Components/FormTextarea.vue'
import SaleItemSelector from '../../Components/Sale/SaleItemSelector.vue'
import { route } from '../../helpers/route.js'

const props = defineProps({
  sale: {
    type: Object,
    required: true,
  },
  items: {
    type: Array,
    required: true,
  },
  vendors: {
    type: Array,
    default: () => [],
  },
  vehicles: {
    type: Array,
    default: () => [],
  },
  user: {
    type: Object,
    required: true,
  },
})

const itemOptions = computed(() => {
  return props.items.map(item => ({
    value: item.id,
    label: `${item.name}${item.sku ? ` (${item.sku})` : ''} - ${item.consignment?.reference_no || 'N/A'}`,
  }))
})

const form = useForm({
  item_id: props.sale.item_id || '',
  quantity: props.sale.quantity || 1,
  price: props.sale.price || 0,
})

const selectedItem = ref(props.items.find(i => i.id === form.item_id) || null)

function onItemSelected(item) {
  selectedItem.value = item
  form.item_id = item.id
  form.price = item.unit_price ?? form.price
  // keep existing quantity unless zero
  if (!form.quantity || form.quantity <= 0) form.quantity = item.quantity_available && item.quantity_available > 0 ? 1 : 0
}

const priceTooLow = computed(() => {
  if (!selectedItem.value) return false
  return Number(form.price) < Number(selectedItem.value.unit_price || 0)
})

const qtyTooHigh = computed(() => {
  if (!selectedItem.value) return false
  return Number(form.quantity) > Number((selectedItem.value.quantity_available ?? 0) + (props.sale.quantity || 0) - (props.sale.item_id === selectedItem.value.id ? props.sale.quantity || 0 : 0))
})

const canSubmit = computed(() => {
  if (!selectedItem.value) return false
  if (priceTooLow.value) return false
  if (qtyTooHigh.value) return false
  return true
})

function submit() {
  form.put(route('sales.update', { id: props.sale.id }))
}
</script>

<style scoped>
</style>

