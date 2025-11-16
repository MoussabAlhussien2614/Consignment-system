<template>
  <Navbar :user="user">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Page Header -->
        <div>
          <Link :href="route('vehicles.index')" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Vehicles
          </Link>
          <h1 class="text-3xl font-bold text-gray-900">Create Vehicle</h1>
          <p class="text-gray-600 mt-1">Add a new vehicle to the system</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <form @submit.prevent="submit" class="space-y-5">
            <FormSelect
              id="vendor_id"
              v-model="form.vendor_id"
              label="Vendor"
              :options="vendorOptions"
              placeholder="Select a vendor"
              :error="form.errors.vendor_id"
              required
            />

            <FormInput
              id="plate_number"
              v-model="form.plate_number"
              label="Plate Number"
              placeholder="Enter plate number"
              :error="form.errors.plate_number"
              required
            />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <FormInput
                id="driver_name"
                v-model="form.driver_name"
                label="Driver Name"
                placeholder="Enter driver name"
                :error="form.errors.driver_name"
              />

              <FormInput
                id="driver_phone"
                v-model="form.driver_phone"
                label="Driver Phone"
                placeholder="Enter driver phone"
                :error="form.errors.driver_phone"
              />
            </div>

            <FormSelect
              id="vehicle_type"
              v-model="form.vehicle_type"
              label="Vehicle Type"
              :options="vehicleTypeOptions"
              placeholder="Select vehicle type"
              :error="form.errors.vehicle_type"
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
                :href="route('vehicles.index')"
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
                <span v-else>Create Vehicle</span>
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

const vehicleTypeOptions = [
  { value: 'car', label: 'Car' },
  { value: 'truck', label: 'Truck' },
  { value: 'van', label: 'Van' },
  { value: 'other', label: 'Other' },
]

const form = useForm({
  vendor_id: '',
  plate_number: '',
  driver_name: '',
  driver_phone: '',
  vehicle_type: 'car',
  notes: '',
})

function submit() {
  form.post(route('vehicles.store'))
}
</script>

<style scoped>
</style>

