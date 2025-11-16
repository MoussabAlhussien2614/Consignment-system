<template>
  <Navbar :user="user">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Page Header -->
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Vehicles</h1>
          <p class="text-gray-600 mt-1">Manage your vehicles</p>
        </div>

        <!-- Data Table -->
        <DataTable
          :columns="columns"
          :data="vehicles.data"
          :pagination="vehicles"
          :filters="filters"
          :index-route="route('vehicles.index')"
          :create-route="route('vehicles.create')"
          :show-route="'vehicles.show'"
          :edit-route="'vehicles.edit'"
          :delete-route="'vehicles.destroy'"
          :on-delete="handleDelete"
          create-button-text="Add Vehicle"
          search-placeholder="Search vehicles by plate number, driver, vendor..."
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
  vehicles: {
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
    key: 'plate_number',
    label: 'Plate Number',
  },
  {
    key: 'vendor.name',
    label: 'Vendor',
  },
  {
    key: 'driver_name',
    label: 'Driver Name',
    defaultValue: '-',
  },
  {
    key: 'driver_phone',
    label: 'Driver Phone',
    defaultValue: '-',
  },
  {
    key: 'vehicle_type',
    label: 'Type',
    format: 'badge',
    badgeClass: (row) => {
      const types = {
        car: 'px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full',
        truck: 'px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full',
        van: 'px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full',
        other: 'px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full',
      }
      return types[row.vehicle_type] || types.other
    },
  },
  {
    key: 'consignments_count',
    label: 'Consignments',
    format: 'badge',
    badgeClass: 'px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 rounded-full',
  },
]

function handleDelete(vehicle) {
  if (confirm('Are you sure you want to delete this vehicle?')) {
    router.delete(route('vehicles.destroy', { id: vehicle.id }), {
      preserveScroll: true,
    })
  }
}
</script>

<style scoped>
</style>

