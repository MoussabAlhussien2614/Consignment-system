<template>
  <Navbar :user="user">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Page Header -->
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Vendors</h1>
          <p class="text-gray-600 mt-1">Manage your vendors</p>
        </div>

        <!-- Data Table -->
        <DataTable
          :columns="columns"
          :data="vendors.data"
          :pagination="vendors"
          :filters="filters"
          :index-route="route('vendors.index')"
          :create-route="route('vendors.create')"
          :show-route="'vendors.show'"
          :edit-route="'vendors.edit'"
          :delete-route="'vendors.destroy'"
          :on-delete="handleDelete"
          create-button-text="Add Vendor"
          search-placeholder="Search vendors by name, code, email..."
        />
      </div>
    </div>
  </Navbar>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import Navbar from '../Navbar.vue'
import DataTable from '../../Components/DataTable.vue'
import { route } from '../../helpers/route.js'

defineProps({
  vendors: {
    type: Object,
    required: true,
  },
  filters: {
    type: Object,
    default: () => ({}),
  },
  user: {
    type: Object,
    required: true,
  },
})

const columns = [
  {
    key: 'name',
    label: 'Name',
  },
  {
    key: 'code',
    label: 'Code',
  },
  {
    key: 'contact_name',
    label: 'Contact Name',
    defaultValue: '-',
  },
  {
    key: 'email',
    label: 'Email',
    defaultValue: '-',
  },
  {
    key: 'vehicles_count',
    label: 'Vehicles',
    format: 'badge',
    badgeClass: 'px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full',
  },
  {
    key: 'consignments_count',
    label: 'Consignments',
    format: 'badge',
    badgeClass: 'px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full',
  },
]

function handleDelete(vendor) {
  if (confirm('Are you sure you want to delete this vendor?')) {
    router.delete(route('vendors.destroy', { id: vendor.id }), {
      preserveScroll: true,
    })
  }
}
</script>

<style scoped>
</style>

