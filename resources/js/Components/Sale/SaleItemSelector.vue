<template>
  <div>
    <button type="button" @click="open = true" class="px-3 py-2 bg-indigo-600 text-white rounded">Select Item</button>

    <div v-if="open" class="fixed inset-0 z-50 flex items-start justify-center p-4">
      <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl">
        <div class="flex items-center justify-between p-4 border-b">
          <h3 class="text-lg font-semibold">Select Consignment Item</h3>
          <button @click="close" class="text-gray-500 hover:text-gray-700">Close</button>
        </div>

        <div class="p-4 space-y-4">
          <div class="flex gap-3">
            <select v-model="filters.vendor_id" class="border rounded px-3 py-2">
              <option value="">All Vendors</option>
              <option v-for="v in vendors" :key="v.id" :value="v.id">{{ v.name }}</option>
            </select>

            <select v-model="filters.vehicle_id" class="border rounded px-3 py-2">
              <option value="">All Vehicles</option>
              <option v-for="v in vehicleOptions" :key="v.id" :value="v.id">{{ v.plate_number }}</option>
            </select>

            <input v-model="filters.search" placeholder="Search name or SKU" class="border rounded px-3 py-2 flex-1" />

            <label class="inline-flex items-center gap-2">
              <input type="checkbox" v-model="filters.available_only" />
              <span class="text-sm">Available only</span>
            </label>
          </div>

          <div class="overflow-auto max-h-96 border rounded">
            <table class="min-w-full divide-y">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-4 py-2 text-left">Name</th>
                  <th class="px-4 py-2 text-left">SKU</th>
                  <th class="px-4 py-2 text-left">Vendor</th>
                  <th class="px-4 py-2 text-left">Vehicle</th>
                  <th class="px-4 py-2 text-right">Available</th>
                  <th class="px-4 py-2 text-right">Unit Price</th>
                  <th class="px-4 py-2">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in filteredItems" :key="item.id" class="border-t">
                  <td class="px-4 py-2">{{ item.name }}</td>
                  <td class="px-4 py-2">{{ item.sku || '-' }}</td>
                  <td class="px-4 py-2">{{ item.consignment?.vendor?.name || '-' }}</td>
                  <td class="px-4 py-2">{{ item.consignment?.vehicle?.plate_number || '-' }}</td>
                  <td class="px-4 py-2 text-right">{{ item.quantity_available ?? 0 }}</td>
                  <td class="px-4 py-2 text-right">{{ formatCurrency(item.unit_price) }}</td>
                  <td class="px-4 py-2 text-center">
                    <button
                      :disabled="(item.quantity_available ?? 0) <= 0"
                      @click="select(item)"
                      class="px-2 py-1 rounded bg-green-600 text-white disabled:opacity-50"
                    >
                      Select
                    </button>
                  </td>
                </tr>
                <tr v-if="filteredItems.length === 0">
                  <td colspan="7" class="p-4 text-center text-gray-500">No items found</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
  items: { type: Array, required: true },
  vendors: { type: Array, default: () => [] },
  vehicles: { type: Array, default: () => [] },
})

const emit = defineEmits(['selected'])

const open = ref(false)
const filters = ref({ vendor_id: '', vehicle_id: '', search: '', available_only: false })

function close() { open.value = false }

function formatCurrency(v) {
  return Number(v || 0).toFixed(2)
}

const filteredItems = computed(() => {
  let list = props.items || []
  if (filters.value.vendor_id) {
    list = list.filter(i => i.consignment?.vendor?.id == filters.value.vendor_id)
  }
  if (filters.value.vehicle_id) {
    list = list.filter(i => i.consignment?.vehicle?.id == filters.value.vehicle_id)
  }
  if (filters.value.available_only) {
    list = list.filter(i => (i.quantity_available ?? 0) > 0)
  }
  if (filters.value.search) {
    const s = filters.value.search.toLowerCase()
    list = list.filter(i => (i.name || '').toLowerCase().includes(s) || (i.sku || '').toLowerCase().includes(s))
  }
  return list
})

const vehicleOptions = computed(() => {
  const map = new Map()
  const list = props.items || []
  for (const i of list) {
    const v = i.consignment?.vehicle
    const vendor = i.consignment?.vendor
    if (!v) continue
    if (filters.value.vendor_id) {
      if (!vendor || vendor.id != filters.value.vendor_id) continue
    }
    if (!map.has(v.id)) map.set(v.id, v)
  }
  return Array.from(map.values()).sort((a, b) => (a.plate_number || '').localeCompare(b.plate_number || ''))
})

watch(() => filters.value.vendor_id, (val) => {
  if (!val) return
  const cur = filters.value.vehicle_id
  if (cur && !vehicleOptions.value.find(v => v.id == cur)) {
    filters.value.vehicle_id = ''
  }
})

function select(item) {
  emit('selected', item)
  open.value = false
}
</script>

<style scoped>
.disabled { opacity: 0.5 }
</style>
