<template>
  <Navbar :user="user">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Page Header -->
        <div>
          <Link :href="route('consignments.index')" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Consignments
          </Link>
          <h1 class="text-3xl font-bold text-gray-900">Create Consignment</h1>
          <p class="text-gray-600 mt-1">Add a new consignment to the system</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <form @submit.prevent="submit" class="space-y-5">
            <FormInput
              id="reference_no"
              v-model="form.reference_no"
              label="Reference Number"
              placeholder="Enter reference number"
              :error="form.errors.reference_no"
              required
            />

            <FormSelect
              id="vendor_id"
              v-model="form.vendor_id"
              label="Vendor"
              :options="vendorOptions"
              placeholder="Select a vendor"
              :error="form.errors.vendor_id"
              required
            />

            <FormSelect
              id="vehicle_id"
              v-model="form.vehicle_id"
              label="Vehicle"
              :options="vehicleOptions"
              placeholder="Select a vehicle"
              :error="form.errors.vehicle_id"
              required
            />

            <FormInput
              id="delivered_at"
              v-model="form.delivered_at"
              type="datetime-local"
              label="Delivered At"
              :error="form.errors.delivered_at"
              :max="todayMax"
          />

            <FormSelect
              id="status"
              v-model="form.status"
              label="Status"
              :options="statusOptions"
              placeholder="Select status"
              :error="form.errors.status"
              required
            />

            <FormTextarea
              id="notes"
              v-model="form.notes"
              label="Notes"
              placeholder="Additional notes (optional)"
              :error="form.errors.notes"
              :rows="3"
            />

            <!-- Consignment Items Section -->
            <div class="pt-6 border-t border-gray-200">
              <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Consignment Items</h2>
                <button
                  type="button"
                  @click="addItem"
                  class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm font-medium"
                >
                  <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Item
                  </span>
                </button>
              </div>

              <div v-if="form.errors.items" class="mb-4 text-sm text-red-600">
                {{ form.errors.items }}
              </div>

              <div v-if="form.items.length === 0" class="text-center py-8 text-gray-500">
                No items added. Click "Add Item" to add items to this consignment.
              </div>

              <div class="space-y-4">
                <ConsignmentItemForm
                  v-for="(item, index) in form.items"
                  :key="index"
                  v-model="form.items[index]"
                  :index="index"
                  :categories="categories"
                  :errors="form.errors"
                  :removable="form.items.length > 1"
                  @remove="removeItem(index)"
                />
              </div>
            </div>

            <div class="flex justify-end gap-4 pt-4">
              <Link
                :href="route('consignments.index')"
                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
              >
                Cancel
              </Link>
              <button
                type="submit"
                :disabled="form.processing || form.items.length === 0"
                class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
              >
                <span v-if="form.processing">Creating...</span>
                <span v-else>Create Consignment</span>
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
import FormTextarea from '../../Components/FormTextarea.vue'
import FormSelect from '../../Components/FormSelect.vue'
import ConsignmentItemForm from '../../Components/Consignment/ConsignmentItemForm.vue'
import { route } from '../../helpers/route.js'

const props = defineProps({
  vendors: {
    type: Array,
    required: true,
  },
  vehicles: {
    type: Array,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
  user: {
    type: Object,
    required: true,
  },
})

const vendorOptions = computed(() => {
  return props.vendors.map(vendor => ({
    value: vendor.id,
    label: vendor.name,
  }))
})

const vehicleOptions = computed(() => {
  return props.vehicles.map(vehicle => ({
    value: vehicle.id,
    label: `${vehicle.plate_number}${vehicle.vendor_id ? ` (${vehicle.vendor_id})` : ''}`,
  }))
})

const todayMax = computed(() => {
  const now = new Date()
  const year = now.getFullYear()
  const month = String(now.getMonth() + 1).padStart(2, '0')
  const day = String(now.getDate()).padStart(2, '0')
  const hours = String(now.getHours()).padStart(2, '0')
  const minutes = String(now.getMinutes()).padStart(2, '0')
  
  return `${year}-${month}-${day}T${hours}:${minutes}`
})

const statusOptions = [
  { value: 'pending', label: 'Pending' },
  { value: 'in_progress', label: 'In Progress' },
  { value: 'closed', label: 'Closed' },
]

function createEmptyItem() {
  return {
    name: '',
    sku: '',
    category_id: '',
    quantity: 1,
    unit_price: 0,
    extra_expences: 0,
    commission_rate: 0,
    notes: '',
  }
}

const form = useForm({
  reference_no: '',
  vendor_id: '',
  vehicle_id: '',
  delivered_at: '',
  status: 'pending',
  notes: '',
  items: [createEmptyItem()],
})

function addItem() {
  form.items.push(createEmptyItem())
}

function removeItem(index) {
  form.items.splice(index, 1)
}

function submit() {
  form.post(route('consignments.store'))
}
</script>

<style scoped>
</style>

