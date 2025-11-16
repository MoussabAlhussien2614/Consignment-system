<template>
  <Navbar :user="user">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Page Header -->
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Consignments</h1>
          <p class="text-gray-600 mt-1">Manage your consignments</p>
        </div>

        <!-- Data Table -->
        <DataTable
          :columns="columns"
          :data="consignments.data"
          :pagination="consignments"
          :filters="filters"
          :index-route="route('consignments.index')"
          :create-route="route('consignments.create')"
          :show-route="'consignments.show'"
          :edit-route="'consignments.edit'"
          :delete-route="'consignments.destroy'"
          :on-delete="handleDelete"
          create-button-text="Add Consignment"
          search-placeholder="Search consignments by reference, vendor, vehicle..."
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
  consignments: {
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
    key: 'reference_no',
    label: 'Reference No',
  },
  {
    key: 'vendor.name',
    label: 'Vendor',
  },
  {
    key: 'vehicle.plate_number',
    label: 'Vehicle',
  },
  {
    key: 'delivered_at',
    label: 'Delivered At',
    defaultValue: '-',
  },
  {
    key: 'status',
    label: 'Status',
    format: 'badge',
    badgeClass: (row) => {
      const statuses = {
        pending: 'px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full',
        in_progress: 'px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full',
        closed: 'px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full',
      }
      return statuses[row.status] || statuses.pending
    },
  },
]

function handleDelete(consignment) {
  if (confirm('Are you sure you want to delete this consignment?')) {
    router.delete(route('consignments.destroy', { id: consignment.id }), {
      preserveScroll: true,
    })
  }
}
</script>

<style scoped>
</style>

