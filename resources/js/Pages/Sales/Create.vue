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
          <h1 class="text-3xl font-bold text-gray-900">Create Sale</h1>
          <p class="text-gray-600 mt-1">Record a new sale</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <form @submit.prevent="submit" class="space-y-5">
            <FormSelect
              id="item_id"
              v-model="form.item_id"
              label="Consignment Item"
              :options="itemOptions"
              placeholder="Select an item"
              :error="form.errors.item_id"
              required
            />

            <FormInput
              id="quantity"
              v-model.number="form.quantity"
              type="number"
              label="Quantity"
              placeholder="Enter quantity"
              :error="form.errors.quantity"
              required
            />

            <FormInput
              id="price"
              v-model.number="form.price"
              type="number"
              step="0.01"
              label="Price"
              placeholder="0.00"
              :error="form.errors.price"
              required
            />

            <div class="flex justify-end gap-4 pt-4">
              <Link
                :href="route('sales.index')"
                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
              >
                Cancel
              </Link>
              <button
                type="submit"
                :disabled="form.processing"
                class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
              >
                <span v-if="form.processing">Creating...</span>
                <span v-else>Create Sale</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </Navbar>
</template>

<script setup>
import { computed } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import Navbar from '../Navbar.vue'
import FormInput from '../../Components/FormInput.vue'
import FormSelect from '../../Components/FormSelect.vue'
import { route } from '../../helpers/route.js'

const props = defineProps({
  items: {
    type: Array,
    required: true,
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
  item_id: '',
  quantity: 1,
  price: 0,
})

function submit() {
  form.post(route('sales.store'))
}
</script>

<style scoped>
</style>

