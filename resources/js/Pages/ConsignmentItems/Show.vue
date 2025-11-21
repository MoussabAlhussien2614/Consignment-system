<template>
  <Navbar >
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
            <h1 class="text-3xl font-bold text-gray-900">{{ consignment_item.name }}</h1>
            <p class="text-gray-600 mt-1">Consignment Details</p>
          </div>
          <div class="flex gap-2">
            <Link
              :href="route('consignments.edit', { consignment: consignment_item.id })"
              class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
            >
              Edit
            </Link>
          </div>
        </div>

        <!-- Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="text-sm font-medium text-gray-500">Name</label>
              <p class="mt-1 text-lg text-gray-900">{{ consignment_item.name || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Category</label>
              <p class="mt-1 text-lg text-gray-900">{{ consignment_item.category?.name || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Unit Price</label>
              <p class="mt-1 text-lg text-gray-900">${{ consignment_item.unit_price || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Commission Rate</label>
              <p class="mt-1 text-lg text-gray-900">%{{ consignment_item.commission_rate || '-' }}</p>
            </div>
      
            <div>
              <label class="text-sm font-medium text-gray-500">SKU </label>
              <p class="mt-1 text-lg text-gray-900">${{ consignment_item.sku || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Quantity</label>
              <p class="mt-1 text-lg text-gray-900">${{ consignment_item.quantity || '-' }}</p>
            </div>
            
            <div>
              <label class="text-sm font-medium text-gray-500">Extra Expenses</label>
              <p class="mt-1 text-lg text-gray-900">${{ consignment_item.extra_expences || '-' }}</p>
            </div>
            <div class="md:col-span-2">
              <label class="text-sm font-medium text-gray-500">Notes</label>
              <p class="mt-1 text-lg text-gray-900">{{ consignment_item.notes }}</p>
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
  consignment_item: {
    type: Object,
    required: true,
  },

})


</script>

<style scoped>
</style>

