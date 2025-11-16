<template>
  <Navbar :user="user">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Page Header -->
        <div>
          <Link :href="route('categories.index')" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Categories
          </Link>
          <h1 class="text-3xl font-bold text-gray-900">Edit Category</h1>
          <p class="text-gray-600 mt-1">Update category information</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <form @submit.prevent="submit" class="space-y-5">
            <FormInput
              id="name"
              v-model="form.name"
              label="Category Name"
              placeholder="Enter category name"
              :error="form.errors.name"
              required
            />
            <div class="flex justify-end gap-4 pt-4">
              <Link
                :href="route('categories.index')"
                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
              >
                Cancel
              </Link>
              <button
                type="submit"
                :disabled="form.processing"
                class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
              >
                <span v-if="form.processing">Updating...</span>
                <span v-else>Update Category</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </Navbar>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import Navbar from '../Navbar.vue'
import FormInput from '../../Components/FormInput.vue'
import FormTextarea from '../../Components/FormTextarea.vue'
import { route } from '../../helpers/route.js'

const props = defineProps({
  category: {
    type: Object,
    required: true,
  },
  user: {
    type: Object,
    required: true,
  },
})

const form = useForm({
  name: props.category.name || '',
  code: props.category.code || '',
  description: props.category.description || '',
})

function submit() {
  form.put(route('categories.update', { id: props.category.id }))
}
</script>

<style scoped>
</style>

