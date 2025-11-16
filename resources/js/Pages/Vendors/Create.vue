<template>
  <Navbar :user="user">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Page Header -->
        <div>
          <Link :href="route('vendors.index')" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Vendors
          </Link>
          <h1 class="text-3xl font-bold text-gray-900">Create Vendor</h1>
          <p class="text-gray-600 mt-1">Add a new vendor to the system</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <form @submit.prevent="submit" class="space-y-5">
            <FormInput
              id="name"
              v-model="form.name"
              label="Vendor Name"
              placeholder="Enter vendor name"
              :error="form.errors.name"
              required
            />

            <FormInput
              id="code"
              v-model="form.code"
              label="Vendor Code"
              placeholder="Enter unique vendor code"
              :error="form.errors.code"
              required
            />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <FormInput
                id="contact_name"
                v-model="form.contact_name"
                label="Contact Name"
                placeholder="Enter contact person name"
                :error="form.errors.contact_name"
              />

              <FormInput
                id="contact_phone"
                v-model="form.contact_phone"
                label="Contact Phone"
                placeholder="Enter contact phone"
                :error="form.errors.contact_phone"
              />
            </div>

            <FormInput
              id="email"
              v-model="form.email"
              type="email"
              label="Email Address"
              placeholder="Enter email address"
              :error="form.errors.email"
            />

            <FormTextarea
              id="address"
              v-model="form.address"
              label="Address"
              placeholder="Enter vendor address"
              :error="form.errors.address"
              :rows="3"
            />

            <FormTextarea
              id="notes"
              v-model="form.notes"
              label="Notes"
              placeholder="Additional notes (optional)"
              :error="form.errors.notes"
              :rows="3"
            />

            <div class="flex justify-end gap-4 pt-4">
              <Link
                :href="route('vendors.index')"
                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
              >
                Cancel
              </Link>
              <button
                type="submit"
                :disabled="form.processing"
                class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
              >
                <span v-if="form.processing">Creating...</span>
                <span v-else>Create Vendor</span>
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

defineProps({
  user: {
    type: Object,
    required: true,
  },
})

const form = useForm({
  name: '',
  code: '',
  contact_name: '',
  contact_phone: '',
  email: '',
  address: '',
  notes: '',
})

function submit() {
  form.post(route('vendors.store'))
}
</script>

<style scoped>
</style>

