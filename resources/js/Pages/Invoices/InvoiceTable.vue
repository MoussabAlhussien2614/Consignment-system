<template>
  <div class="space-y-4">
    <!-- Search and Actions Bar -->
    <div v-if="searchable || showCreateButton" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
      <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
        <form v-if="searchable" @submit.prevent="handleSearch" class="flex-1 w-full sm:w-auto">
          <div class="flex gap-2">
            <input
              v-model="searchQuery"
              type="text"
              :placeholder="searchPlaceholder"
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
              :href="indexRoute"
              class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
            >
              Clear
            </Link>
          </div>
        </form>
        <Link
          v-if="showCreateButton"
          :href="createRoute"
          class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg whitespace-nowrap"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          {{ createButtonText }}
        </Link>
      </div>
    </div>

    <!-- Success Message -->
    <div v-if="$page.props.flash?.success" class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
      {{ $page.props.flash.success }}
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th
                v-for="column in columns"
                :key="column.key"
                :class="[
                  'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider',
                  column.align === 'right' ? 'text-right' : 'text-left',
                ]"
              >
                {{ column.label }}
              </th>
              <th v-if="showActions" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="(row, index) in data" :key="getRowKey(row, index)" class="hover:bg-gray-50">
              <td
                v-for="column in columns"
                :key="column.key"
                :class="[
                  'px-6 py-4 whitespace-nowrap',
                  column.align === 'right' ? 'text-right' : '',
                ]"
              >
                <slot :name="`cell-${column.key}`" :row="row" :value="getNestedValue(row, column.key)">
                  <div v-if="column.format === 'badge'" class="inline-block">
                    <span :class="getBadgeClass(row, column)">
                      {{ getNestedValue(row, column.key) || column.defaultValue || '-' }}
                    </span>
                  </div>
                  <div v-else-if="column.format === 'currency'" class="text-sm font-medium text-gray-900">
                    ${{ formatCurrency(getNestedValue(row, column.key)) }}
                  </div>
                  <div v-else :class="column.class || 'text-sm text-gray-900'">
                    {{ getNestedValue(row, column.key) || column.defaultValue || '-' }}
                  </div>
                </slot>
              </td>
              <td v-if="showActions" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex justify-end gap-2">
                  <Link
                    v-if="showRoute"
                    :href="getRoute(showRoute, getRowId(row))"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors text-sm font-medium"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View
                  </Link>
                  <Link
                    v-if="editRoute"
                    :href="getRoute(editRoute, getRowId(row))"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                  </Link>
                  <button
                    v-if="onDelete"
                    @click="handleDelete(row)"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="data.length === 0">
              <td :colspan="columns.length + (showActions ? 1 : 0)" class="px-6 py-4 text-center text-gray-500">
                {{ emptyMessage }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="pagination && pagination.links && pagination.links.length > 3" class="bg-gray-50 px-4 py-3 border-t border-gray-200">
        <div class="flex items-center justify-between">
          <div class="text-sm text-gray-700">
            Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} results
          </div>
          <div class="flex gap-2">
            <Link
              v-for="link in pagination.links"
              :key="link.label"
              :href="link.url || '#'"
              :class="[
                'px-3 py-2 text-sm rounded-lg',
                link.active
                  ? 'bg-indigo-600 text-white'
                  : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-300',
                !link.url ? 'opacity-50 cursor-not-allowed' : ''
              ]"
              v-html="link.label"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { route } from '../helpers/route.js'

const props = defineProps({
  columns: {
    type: Array,
    required: true,
  },
  data: {
    type: Array,
    required: true,
  },
  pagination: {
    type: Object,
    default: null,
  },
  filters: {
    type: Object,
    default: null,
  },
  searchable: {
    type: Boolean,
    default: true,
  },
  searchPlaceholder: {
    type: String,
    default: 'Search...',
  },
  showActions: {
    type: Boolean,
    default: true,
  },
  showCreateButton: {
    type: Boolean,
    default: true,
  },
  createButtonText: {
    type: String,
    default: 'Add New',
  },
  createRoute: {
    type: String,
    default: '',
  },
  indexRoute: {
    type: String,
    default: '',
  },
  showRoute: {
    type: String,
    default: '',
  },
  editRoute: {
    type: String,
    default: '',
  },
  deleteRoute: {
    type: String,
    default: '',
  },
  onDelete: {
    type: Function,
    default: null,
  },
  emptyMessage: {
    type: String,
    default: 'No data found',
  },
  rowKey: {
    type: String,
    default: 'id',
  },
})

const searchQuery = ref(props.filters?.search || '')

function getNestedValue(obj, path) {
  return path.split('.').reduce((current, prop) => current?.[prop], obj)
}

function getRowKey(row, index) {
  return getNestedValue(row, props.rowKey) || index
}

function getRowId(row) {
  return getNestedValue(row, props.rowKey)
}

function getRoute(routeName, id) {
  return route(routeName, { id })
}

function formatCurrency(value) {
  return parseFloat(value || 0).toFixed(2)
}

function getBadgeClass(row, column) {
  if (column.badgeClass) {
    return typeof column.badgeClass === 'function'
      ? column.badgeClass(row)
      : column.badgeClass
  }
  return 'px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full'
}

function handleSearch() {
  if (props.indexRoute) {
    router.get(props.indexRoute, { search: searchQuery.value }, {
      preserveState: true,
      preserveScroll: true,
    })
  }
}

function handleDelete(row) {
  if (props.onDelete) {
    props.onDelete(row)
  } else if (props.deleteRoute) {
    const id = getRowId(row)
    if (confirm('Are you sure you want to delete this item?')) {
      router.delete(route(props.deleteRoute, { id }), {
        preserveScroll: true,
      })
    }
  }
}
</script>

<style scoped>
</style>

