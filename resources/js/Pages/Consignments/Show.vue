<template>
  <Navbar :user="user">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex justify-between items-start">
          <div>
            <Link :href="route('consignments.index')" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-flex items-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
              Back to Consignments
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">{{ consignment.reference_no }}</h1>
            <p class="text-gray-600 mt-1">Consignment Details</p>
          </div>
          <Link
            :href="route('consignments.edit', { id: consignment.id })"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
          >
            Edit
          </Link>
        </div>

        <!-- Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="text-sm font-medium text-gray-500">Vendor</label>
              <p class="mt-1 text-lg text-gray-900">{{ consignment.vendor?.name || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Vehicle</label>
              <p class="mt-1 text-lg text-gray-900">{{ consignment.vehicle?.plate_number || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Status</label>
              <p class="mt-1">
                <span :class="getStatusBadgeClass(consignment.status)" class="px-3 py-1 rounded-full text-sm font-medium">
                  {{ formatStatus(consignment.status) }}
                </span>
              </p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Delivered At</label>
              <p class="mt-1 text-lg text-gray-900">{{ formatDate(consignment.delivered_at) || '-' }}</p>
            </div>
            <div v-if="consignment.notes" class="md:col-span-2">
              <label class="text-sm font-medium text-gray-500">Notes</label>
              <p class="mt-1 text-lg text-gray-900">{{ consignment.notes }}</p>
            </div>
          </div>
        </div>

        <!-- Items Card -->
        <div v-if="consignment.items && consignment.items.length > 0" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Items ({{ consignment.items.length }})</h3>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Available</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="item in consignment.items" :key="item.id">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ item.product?.name || '-' }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ item.quantity }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ item.available_quantity }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ parseFloat(item.unit_price || 0).toFixed(2) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </Navbar>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Navbar from '../Navbar.vue'
import { route } from '../../helpers/route.js'

defineProps({
  consignment: {
    type: Object,
    required: true,
  },
  user: {
    type: Object,
    required: true,
  },
})

function formatStatus(status) {
  const statusMap = {
    pending: 'Pending',
    in_progress: 'In Progress',
    closed: 'Closed',
  }
  return statusMap[status] || status
}

function getStatusBadgeClass(status) {
  const classes = {
    pending: 'bg-yellow-100 text-yellow-800',
    in_progress: 'bg-blue-100 text-blue-800',
    closed: 'bg-green-100 text-green-800',
  }
  return classes[status] || classes.pending
}

function formatDate(dateTime) {
  if (!dateTime) return null
  return new Date(dateTime).toLocaleString()
}
</script>

<style scoped>
</style>

