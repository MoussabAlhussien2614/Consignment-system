<template>
  <Navbar :user="user">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <div class="flex justify-between items-start">
          <div>
            <Link :href="route('sales.index')" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-flex items-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
              Back to Sales
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">Sale #{{ sale.id }}</h1>
            <p class="text-gray-600 mt-1">Sale Details</p>
          </div>
          <div class="flex gap-2">
            <Link
              :href="route('sales.edit', { id: sale.id })"
              class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
            >
              Edit
            </Link>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="text-sm font-medium text-gray-500">Item name</label>
              <p class="mt-1 text-lg text-gray-900">{{ sale.item?.name || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">SKU</label>
              <p class="mt-1 text-lg text-gray-900">{{ sale.item?.sku || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Category</label>
              <p class="mt-1 text-lg text-gray-900">{{ sale.item?.category?.name || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Consigmnent</label>
              <p class="mt-1 text-lg text-gray-900">{{ sale.item?.consignment?.reference_no || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Vendor</label>
              <p class="mt-1 text-lg text-gray-900">{{ sale.item?.consignment?.vendor?.name || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Vehicle</label>
              <p class="mt-1 text-lg text-gray-900">{{ sale.item?.consignment?.vehicle?.plate_number || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Quantity</label>
              <p class="mt-1 text-lg text-gray-900">{{ sale.quantity }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Price</label>
              <p class="mt-1 text-lg text-gray-900">${{ parseFloat(sale.price || 0).toFixed(2) }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Total Amount</label>
              <p class="mt-1 text-lg font-semibold text-gray-900">${{ parseFloat((sale.price || 0) * (sale.quantity || 0)).toFixed(2) }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Date</label>
              <p class="mt-1 text-lg text-gray-900">{{ formatDate(sale.created_at) }}</p>
            </div>
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
  sale: {
    type: Object,
    required: true,
  },
  user: {
    type: Object,
    required: true,
  },
})

function formatDate(dateTime) {
  if (!dateTime) return '-'
  return new Date(dateTime).toLocaleString()
}
</script>

<style scoped>
</style>

