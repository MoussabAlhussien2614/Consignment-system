<template>
  <Navbar :user="user">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Sales</h1>
          <p class="text-gray-600 mt-1">Manage your Sales</p>
        </div>
        <DataTable
          :columns="columns"
          :data="sales.data"
          :pagination="sales"
          :filters="filters"
          :index-route="route('sales.index')"
          :create-route="route('sales.create')"
          :show-route="'sales.show'"
          :edit-route="'sales.edit'"
          :delete-route="'sales.destroy'"
          :on-delete="handleDelete"
          create-button-text="Add Sale"
          search-placeholder="Search sales by item name, SKU, consignment reference..."
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
  sales: {
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
    key: 'item.name',
    label: 'Item Name',
  },
  {
    key: 'Item.sku',
    label: 'SKU',
    defaultValue: '-',
  },
  {
    key: 'item.consignment.reference_no',
    label: 'Consignment',
  },
  {
    key: 'quantity',
    label: 'Quantity',
  },
  {
    key: 'quantity',
    label: 'Quantity',
  },
  {
    key: 'price',
    label: 'Price',
    format: 'currency',
  },
  {
    key: 'created_at',
    label: 'Date',
    defaultValue: '-'
  },
]

function handleDelete(sale) {
  if (confirm('Are you sure you want to delete this sale?')) {
    router.delete(route('sales.destroy', { id: sale.id }), {
      preserveScroll: true,
    })
  }
}
</script>

<style scoped>
</style>

