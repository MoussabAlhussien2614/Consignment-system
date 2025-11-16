<template>
  <Navbar :user="user">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex justify-between items-start">
          <div>
            <Link :href="route('categories.index')" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-flex items-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
              Back to Categories
            </Link>
            <h1 class="text-3xl font-bold text-gray-900">{{ category.name }}</h1>
            <p class="text-gray-600 mt-1">Category Details</p>
          </div>
          <Link
            :href="route('categories.edit', { id: category.id })"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
          >
            Edit
          </Link>
        </div>

        <!-- Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <h3 class="text-sm font-medium text-gray-500">Name</h3>
              <p class="mt-1 text-lg text-gray-900">{{ category.name }}</p>
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
  category: {
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

