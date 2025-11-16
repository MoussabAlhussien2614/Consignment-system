<template>
  <Navbar :user="user">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex justify-between items-start">
          <div>
            <Link :href="route('vendors.index')" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-flex items-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
              Back to Vendors
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">{{ vendor.name }}</h1>
            <p class="text-gray-600 mt-1">Vendor Details</p>
          </div>
          <Link
            :href="route('vendors.edit', { id: vendor.id })"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
          >
            Edit
          </Link>
        </div>

        <!-- Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="text-sm font-medium text-gray-500">Vendor Code</label>
              <p class="mt-1 text-lg text-gray-900">{{ vendor.code }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Contact Name</label>
              <p class="mt-1 text-lg text-gray-900">{{ vendor.contact_name || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Contact Phone</label>
              <p class="mt-1 text-lg text-gray-900">{{ vendor.contact_phone || '-' }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">Email Address</label>
              <p class="mt-1 text-lg text-gray-900">{{ vendor.email || '-' }}</p>
            </div>
            <div class="md:col-span-2">
              <label class="text-sm font-medium text-gray-500">Address</label>
              <p class="mt-1 text-lg text-gray-900">{{ vendor.address || '-' }}</p>
            </div>
            <div v-if="vendor.notes" class="md:col-span-2">
              <label class="text-sm font-medium text-gray-500">Notes</label>
              <p class="mt-1 text-lg text-gray-900">{{ vendor.notes }}</p>
            </div>
          </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Vehicles ({{ vendor.vehicles?.length || 0 }})</h3>
            <div v-if="vendor.vehicles && vendor.vehicles.length > 0" class="space-y-2">
              <div
                v-for="vehicle in vendor.vehicles"
                :key="vehicle.id"
                class="p-3 bg-gray-50 rounded-lg border border-gray-200"
              >
                <p class="font-medium text-gray-900">{{ vehicle.plate_number }}</p>
                <p class="text-sm text-gray-500">{{ vehicle.driver_name || 'No driver' }}</p>
              </div>
            </div>
            <p v-else class="text-gray-500">No vehicles assigned</p>
          </div>

          <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Consignments ({{ vendor.consignments?.length || 0 }})</h3>
            <div v-if="vendor.consignments && vendor.consignments.length > 0" class="space-y-2">
              <div
                v-for="consignment in vendor.consignments"
                :key="consignment.id"
                class="p-3 bg-gray-50 rounded-lg border border-gray-200"
              >
                <p class="font-medium text-gray-900">{{ consignment.reference_no }}</p>
                <p class="text-sm text-gray-500">{{ consignment.status || 'No status' }}</p>
              </div>
            </div>
            <p v-else class="text-gray-500">No consignments</p>
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
  vendor: {
    type: Object,
    required: true,
  },
  user: {
    type: Object,
    required: true,
  },
})
</script>

<style scoped>
</style>

