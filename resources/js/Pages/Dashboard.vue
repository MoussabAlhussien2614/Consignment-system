<template>
  <Navbar :user="user">
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
      <!-- Welcome Card -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 sm:px-8 py-6">
          <h2 class="text-xl sm:text-2xl font-bold text-white mb-2">Welcome back, {{ user.name }}! 👋</h2>
          <p class="text-indigo-100 text-sm sm:text-base">You're successfully logged into your dashboard</p>
        </div>
      </div>

      <!-- Statistics Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <!-- Sales Card -->
        <Link :href="route('sales.index')" class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100 hover:shadow-lg transition-all duration-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600 mb-1">Total Sales</p>
              <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ statistics.sales }}</p>
            </div>
            <div class="bg-green-500 rounded-full p-3 sm:p-4">
              <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
        </Link>

        <!-- Vendors Card -->
        <Link :href="route('vendors.index')" class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100 hover:shadow-lg transition-all duration-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600 mb-1">Vendors</p>
              <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ statistics.vendors }}</p>
            </div>
            <div class="bg-blue-500 rounded-full p-3 sm:p-4">
              <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
          </div>
        </Link>

        <!-- Vehicles Card -->
        <Link :href="route('vehicles.index')" class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100 hover:shadow-lg transition-all duration-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600 mb-1">Vehicles</p>
              <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ statistics.vehicles }}</p>
            </div>
            <div class="bg-purple-500 rounded-full p-3 sm:p-4">
              <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
              </svg>
            </div>
          </div>
        </Link>

        <!-- Consignments Card -->
        <Link :href="route('consignments.index')" class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl p-6 border border-orange-100 hover:shadow-lg transition-all duration-200">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600 mb-1">Consignments</p>
              <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ statistics.consignments }}</p>
            </div>
            <div class="bg-orange-500 rounded-full p-3 sm:p-4">
              <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
            </div>
          </div>
        </Link>
      </div>

      <!-- Quick Actions -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4 sm:p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
          <div class="space-y-3">
            <Link :href="route('sales.create')" class="block w-full text-left px-4 py-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors border border-gray-200">
              <div class="flex items-center gap-3">
                <div class="bg-green-100 rounded-lg p-2">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                </div>
                <span class="font-medium text-gray-700">Create New Sale</span>
              </div>
            </Link>
            <Link :href="route('consignments.create')" class="block w-full text-left px-4 py-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors border border-gray-200">
              <div class="flex items-center gap-3">
                <div class="bg-indigo-100 rounded-lg p-2">
                  <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                </div>
                <span class="font-medium text-gray-700">Create New Consignment</span>
              </div>
            </Link>
            <Link :href="route('vendors.create')" class="block w-full text-left px-4 py-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors border border-gray-200">
              <div class="flex items-center gap-3">
                <div class="bg-blue-100 rounded-lg p-2">
                  <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                </div>
                <span class="font-medium text-gray-700">Add New Vendor</span>
              </div>
            </Link>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-4 sm:p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">System Overview</h3>
          <div class="space-y-3">
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
              <div class="bg-green-100 rounded-full p-2">
                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">System Active</p>
                <p class="text-xs text-gray-500">All systems operational</p>
              </div>
            </div>
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
              <div class="bg-blue-100 rounded-full p-2">
                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                  <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">Database Connected</p>
                <p class="text-xs text-gray-500">All data synced</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </Navbar>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Navbar from './Navbar.vue'
import { route } from '../helpers/route.js'

defineProps({
  user: {
    type: Object,
    required: true,
  },
  statistics: {
    type: Object,
    required: true,
    default: () => ({
      sales: 0,
      vendors: 0,
      vehicles: 0,
      consignments: 0,
    }),
  },
})
</script>

<style scoped>
</style>
