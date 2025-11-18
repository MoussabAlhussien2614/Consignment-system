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
              @add-new="openVendorModal"
            />

            <FormSelect
              id="vehicle_id"
              v-model="form.vehicle_id"
              label="Vehicle"
              :options="vehicleOptions"
              placeholder="Select a vehicle"
              :error="form.errors.vehicle_id"
              required
              @add-new="openVehicleModal"
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
                  :categories="localCategories"
                  :errors="form.errors"
                  :removable="form.items.length > 1"
                  @remove="removeItem(index)"
                  @open-add-category-modal="openCategoryModal"
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
                <span v-if="form.processing">Updating...</span>
                <span v-else>Update Consignment</span>
              </button>
            </div>
          </form>
        </div>
      </div>

      <QuickCreateModal
        :is-open="vendorModalOpen"
        title="Add New Vendor"
        :fields="vendorFields"
        :store-url="route('vendors.store')"
        @close="vendorModalOpen = false"
        @created="handleVendorCreated"
      />

      <QuickCreateModal
        :is-open="vehicleModalOpen"
        title="Add New Vehicle"
        :fields="vehicleFields"
        :store-url="route('vehicles.store')"
        :initial-data="{ vendor_id: form.vendor_id || '' }"
        @close="vehicleModalOpen = false"
        @created="handleVehicleCreated"
      />

      <QuickCreateModal
        :is-open="categoryModalOpen"
        title="Add New Category"
        :fields="categoryFields"
        :store-url="route('categories.store')"
        @close="categoryModalOpen = false"
        @created="handleCategoryCreated"
      />
    </div>
  </Navbar>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import Navbar from '../Navbar.vue'
import FormInput from '../../Components/FormInput.vue'
import FormTextarea from '../../Components/FormTextarea.vue'
import FormSelect from '../../Components/FormSelect.vue'
import ConsignmentItemForm from '../../Components/Consignment/ConsignmentItemForm.vue'
import QuickCreateModal from '../../Components/QuickCreateModal.vue'
import { route } from '../../helpers/route.js'

const props = defineProps({
  consignment: {
    type: Object,
    required: true,
  },
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

const localVendors = ref([...props.vendors])
const localVehicles = ref([...props.vehicles])
const localCategories = ref([...props.categories])

const vendorModalOpen = ref(false)
const vehicleModalOpen = ref(false)
const categoryModalOpen = ref(false)
const categoryModalItemIndex = ref(null)

const vendorOptions = computed(() => [
  ...localVendors.value.map(v => ({ value: v.id, label: v.name })),
  { value: 'add_new_vendor', label: '+ Add New Vendor' }
])

const vehicleOptions = computed(() => [
  ...localVehicles.value.map(v => ({ 
    value: v.id, 
    label: `${v.plate_number}${v.vendor?.name ? ` (${v.vendor.name})` : ''}` 
  })),
  { value: 'add_new_vehicle', label: '+ Add New Vehicle' }
])

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

function formatDateTimeForInput(dateTime) {
  if (!dateTime) return ''
  const date = new Date(dateTime)
  const year = date.getFullYear()
  const month = String(date.getMonth() + 1).padStart(2, '0')
  const day = String(date.getDate()).padStart(2, '0')
  const hours = String(date.getHours()).padStart(2, '0')
  const minutes = String(date.getMinutes()).padStart(2, '0')
  return `${year}-${month}-${day}T${hours}:${minutes}`
}

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

function mapItemsForForm(items) {
  if (!items || items.length === 0) {
    return [createEmptyItem()]
  }
  return items.map(item => ({
    name: item.name || '',
    sku: item.sku || '',
    category_id: item.category_id || '',
    quantity: item.quantity || 1,
    unit_price: item.unit_price || 0,
    extra_expences: item.extra_expences || 0,
    commission_rate: item.commission_rate || 0,
    notes: item.notes || '',
  }))
}

const form = useForm({
  reference_no: props.consignment.reference_no || '',
  vendor_id: props.consignment.vendor_id || '',
  vehicle_id: props.consignment.vehicle_id || '',
  delivered_at: formatDateTimeForInput(props.consignment.delivered_at),
  status: props.consignment.status || 'pending',
  notes: props.consignment.notes || '',
  items: mapItemsForForm(props.consignment.items),
})

watch(
  () => props.consignment.items,
  (items) => {
    if (items) {
      items.forEach((item) => {
        if (item.category && !localCategories.value.find(c => c.id === item.category.id)) {
          localCategories.value.push(item.category)
        }
      })
    }
  },
  { immediate: true }
)

function addItem() {
  form.items.push(createEmptyItem())
}

function removeItem(index) {
  form.items.splice(index, 1)
}

function submit() {
  form.put(route('consignments.update', { id: props.consignment.id }))
}

function openVendorModal() {
  vendorModalOpen.value = true
}

function openVehicleModal() {
  vehicleModalOpen.value = true
}

function openCategoryModal({ index }) {
  categoryModalItemIndex.value = index
  categoryModalOpen.value = true
}

function handleVendorCreated(vendor) {
  localVendors.value.push(vendor)
  form.vendor_id = vendor.id
  vendorModalOpen.value = false
}

function handleVehicleCreated(vehicle) {
  localVehicles.value.push(vehicle)
  form.vehicle_id = vehicle.id
  vehicleModalOpen.value = false
}

function handleCategoryCreated(category) {
  localCategories.value.push(category)
  if (categoryModalItemIndex.value !== null) {
    form.items[categoryModalItemIndex.value].category_id = category.id
  }
  categoryModalItemIndex.value = null
  categoryModalOpen.value = false
}

const vendorFields = [
  { name: 'name', label: 'Vendor Name', placeholder: 'Enter vendor name', required: true },
  { name: 'code', label: 'Vendor Code', placeholder: 'Enter vendor code', required: true },
  { name: 'contact_name', label: 'Contact Name', placeholder: 'Enter contact name' },
  { name: 'contact_phone', label: 'Contact Phone', placeholder: 'Enter contact phone' },
  { name: 'email', label: 'Email', type: 'email', placeholder: 'Enter email' },
  { name: 'address', label: 'Address', type: 'textarea', placeholder: 'Enter address' },
]

const vehicleFields = computed(() => [
  { 
    name: 'vendor_id', 
    label: 'Vendor', 
    type: 'select',
    options: localVendors.value.map(v => ({ value: v.id, label: v.name })),
    required: true 
  },
  { name: 'plate_number', label: 'Plate Number', placeholder: 'Enter plate number', required: true },
  { name: 'driver_name', label: 'Driver Name', placeholder: 'Enter driver name' },
  { name: 'driver_phone', label: 'Driver Phone', placeholder: 'Enter driver phone' },
  { 
    name: 'vehicle_type', 
    label: 'Vehicle Type', 
    type: 'select',
    options: [
      { value: 'car', label: 'Car' },
      { value: 'truck', label: 'Truck' },
      { value: 'van', label: 'Van' },
      { value: 'other', label: 'Other' },
    ],
    required: true 
  },
  { name: 'notes', label: 'Notes', type: 'textarea', placeholder: 'Enter notes' },
])

const categoryFields = [
  { name: 'name', label: 'Category Name', placeholder: 'Enter category name', required: true },
]
</script>

<style scoped>
</style>

