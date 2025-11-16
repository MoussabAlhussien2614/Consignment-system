<template>
  <Navbar :user="user">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Page Header -->
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
          <p class="text-gray-600 mt-1">Manage your categories</p>
        </div>

        <!-- Data Table -->
        <DataTable
          :columns="columns"
          :data="categories.data"
          :pagination="categories"
          :filters="filters"
          :index-route="route('categories.index')"
          :create-route="route('categories.create')"
          :show-route="'categories.show'"
          :edit-route="'categories.edit'"
          :delete-route="'categories.destroy'"
          :on-delete="handleDelete"
          create-button-text="Add Category"
          search-placeholder="Search categories by name, code..."
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
  categories: {
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
  }
]

function handleDelete(category) {
  if (confirm('Are you sure you want to delete this category?')) {
    router.delete(route('categories.destroy', { id: category.id }), {
      preserveScroll: true,
    })
  }
}
</script>

<style scoped>
</style>

