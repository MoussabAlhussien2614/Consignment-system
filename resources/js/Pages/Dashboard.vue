<template>
    <Navbar>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Welcome Card -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
          <h2 class="text-2xl font-bold text-white mb-2">Welcome back, {{ user.name }}! 👋</h2>
          <p class="text-indigo-100">You're successfully logged into your dashboard</p>
        </div>
        <div class="p-8">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- User Info Card -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
              <div class="flex items-center gap-4">
                <div class="bg-blue-500 rounded-full p-3">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-600">Account</p>
                  <p class="text-lg font-semibold text-gray-900">Active</p>
                </div>
              </div>
            </div>

            <!-- Email Card -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
              <div class="flex items-center gap-4">
                <div class="bg-purple-500 rounded-full p-3">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-600">Email</p>
                  <p class="text-lg font-semibold text-gray-900 truncate">{{ user.email }}</p>
                </div>
              </div>
            </div>

            <!-- Status Card -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
              <div class="flex items-center gap-4">
                <div class="bg-green-500 rounded-full p-3">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-600">Status</p>
                  <p class="text-lg font-semibold text-gray-900">Verified</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
          <div class="space-y-3">
            <button class="w-full text-left px-4 py-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors border border-gray-200">
              <div class="flex items-center gap-3">
                <div class="bg-indigo-100 rounded-lg p-2">
                  <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                </div>
                <span class="font-medium text-gray-700">Create New Item</span>
              </div>
            </button>
            <button class="w-full text-left px-4 py-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors border border-gray-200">
              <div class="flex items-center gap-3">
                <div class="bg-purple-100 rounded-lg p-2">
                  <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                </div>
                <span class="font-medium text-gray-700">View All Items</span>
              </div>
            </button>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
          <div class="space-y-3">
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
              <div class="bg-green-100 rounded-full p-2">
                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">Account Created</p>
                <p class="text-xs text-gray-500">Welcome to the system</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </Navbar>
  
</template>

<script setup>
import Navbar  from './Navbar.vue'

defineProps({
  user: {
    type: Object,
    required: true,
  },
})


</script>

<style scoped>
</style>
