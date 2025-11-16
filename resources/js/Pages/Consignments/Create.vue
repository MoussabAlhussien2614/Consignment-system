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

            <div class="flex justify-end gap-4 pt-4">
              <Link
                :href="route('consignments.index')"
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

const form = useForm({
  reference_no: '',
  vendor_id: '',
  vehicle_id: '',
  delivered_at: '',
  status: 'pending',
  notes: '',
})

function submit() {
  form.post(route('consignments.store'))
}
</script>

<style scoped>
</style>

