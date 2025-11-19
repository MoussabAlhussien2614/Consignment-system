<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <Link :href="route('dashboard')">
              <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Consignment System
              </h1>
            </Link>
          </div>
          
          <!-- Desktop Navigation -->
          <nav class="hidden lg:flex space-x-6 lg:space-x-8">
            <Link :href="route('dashboard')" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors whitespace-nowrap">
              Dashboard
            </Link>
            <Link :href="route('sales.index')" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors whitespace-nowrap">
              Sales
            </Link>
            <Link :href="route('consignments.index')" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors whitespace-nowrap">
              Consignments
            </Link>
            <Link :href="route('vendors.index')" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors whitespace-nowrap">
              Vendors
            </Link>

            <Link :href="route('invoices')" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors whitespace-nowrap">
              Invoices
            </Link>
          </nav>

          <div class="flex items-center gap-2 sm:gap-4">
            <!-- Mobile Menu Button -->
            <button
              @click="mobileMenuOpen = !mobileMenuOpen"
              class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors"
            >
              <svg v-if="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
            
            <form @submit.prevent="logout" class="inline">
              <button
                type="submit"
                class="inline-flex items-center gap-1 sm:gap-2 px-3 sm:px-4 py-2 border border-transparent text-xs sm:text-sm font-medium rounded-lg text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="hidden sm:inline">Logout</span>
              </button>
            </form>
          </div>
        </div>

        <!-- Mobile Navigation -->
        <nav v-if="mobileMenuOpen" class="lg:hidden border-t border-gray-200 py-4 space-y-2">
          <Link :href="route('dashboard')" @click="mobileMenuOpen = false" class="block px-4 py-2 font-medium text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
            Dashboard
          </Link>
          <Link :href="route('sales.index')" @click="mobileMenuOpen = false" class="block px-4 py-2 font-medium text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
            Sales
          </Link>
          <Link :href="route('consignments.index')" @click="mobileMenuOpen = false" class="block px-4 py-2 font-medium text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
            Consignments
          </Link>
          <Link :href="route('vendors.index')" @click="mobileMenuOpen = false" class="block px-4 py-2 font-medium text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
            Vendors
          </Link>
          <Link :href="route('vehicles.index')" @click="mobileMenuOpen = false" class="block px-4 py-2 font-medium text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
            Vehicles
          </Link>
          <Link :href="route('invoices')" @click="mobileMenuOpen = false" class="block px-4 py-2 font-medium text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
            Invoices
          </Link>
          <Link :href="route('categories.index')" @click="mobileMenuOpen = false" class="block px-4 py-2 font-medium text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
            Categories
          </Link>
        </nav>
      </div>
    </header>
    <slot></slot>
  </div>
       
</template>

<script setup>
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import { route } from '../helpers/route.js'

defineProps({
  user: {
    type: Object,
    required: true,
  },
})

const mobileMenuOpen = ref(false)

function logout() {
  router.post('/logout')
}
</script>

<style scoped>
</style>
