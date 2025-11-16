<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-.">
            <Link :href="route('dashboard')">
              <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Consignment System
              </h1>
            </Link>
          </div>
          <div class="flex space-x-8 overflow-x-auto py-4">
            <Link :href="route('dashboard')" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
              Dashboard
            </Link>
            <Link :href="route('consignments.index')" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
              Consignments
            </Link>
            <Link :href="route('vendors.index')" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
              Vendors
            </Link>
            <Link :href="route('vehicles.index')" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
              Vehicles
            </Link>
            <Link :href="route('invoices')" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
              Invoices
            </Link>
            <Link :href="route('categories.index')" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
              Categories
            </Link>
          </div>

          <div class="flex items-center gap-4">
            <!-- <div class="text-right">
              <p class="text-sm font-medium text-gray-900">{{ user.name }}</p>
              <p class="text-xs text-gray-500">{{ user.email }}</p>
            </div> -->
            <form @submit.prevent="logout" class="inline">
              <button
                type="submit"
                class="inline-flex items-center gap-2 px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
              </button>
            </form>
          </div>
        </div>

 
      </div>
    </header>
    <slot></slot>
  </div>
       
</template>

<script setup>
import { router, Link } from '@inertiajs/vue3'
import { route } from '../helpers/route.js'

defineProps({
  user: {
    type: Object,
    required: true,
  },
})

function logout() {
  router.post('/logout')
}
</script>

<style scoped>
</style>
