<template>
    <Navbar>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
         <div>
          <h1 class="text-3xl font-bold text-gray-900">Consignment Items</h1>
          <p class="text-gray-600 mt-1">Manage you consignment items</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
          <form  @submit.prevent="handleSearch" class="flex-1 w-full sm:w-auto">
            <div class="flex gap-2">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search consignments by name, category, SKU, consignment reference..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              />
              <button
                type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
              >
                Search
              </button>
              <Link
                v-if="filters?.search"
                :href="route('cosignment-items')"
                class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
              >
                Clear
              </Link>
            </div>
          </form>
          <Link
            :href="createRoute"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg whitespace-nowrap"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Consignment
          </Link>
        </div>
      </div>
        <ConsignmentItemTable
         :data="items.data"
         :pagination="items"
        />
      </div>
    </div>
  </Navbar>
  
</template>

<script setup>
import Navbar  from '../Navbar.vue'
import ConsignmentItemTable from './ConsignmentItemTable.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineProps({
  items:{
    type: Array,
    required: false,
    
  }
})
const form = useForm({
  view_mode: "",
})
let searchQuery = ""
const handleSearch = () => {

}
</script>

<style scoped>
</style>
