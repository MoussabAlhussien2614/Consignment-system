<template>
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
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                <div v-if="column.format === 'badge'" class="inline-block">
                  <span class='px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full'>
                    {{ getNestedValue(row, column.key) || column.defaultValue || '-' }}
                  </span>
                </div>
                <div v-else-if="column.format === 'currency'" class="text-sm font-medium text-gray-900">
                  ${{ formatCurrency(getNestedValue(row, column.key)) }}
                </div>
                <div v-else :class="column.class || 'text-sm text-gray-900'">
                  {{ getNestedValue(row, column.key) || column.defaultValue || '-' }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex justify-end gap-2">
                  <Link
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
                    :href="getRoute(editRoute, getRowId(row))"
                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-orange-100 text-orange-800 rounded-lg hover:bg-orange-200 transition-colors text-sm font-medium"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="#FFA500" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print
                  </Link>
                 
                </div>
              </td>
            </tr>
            <tr v-if="data.length==0&&!venderIsSelected">
              <td :colspan="columns.length + (showActions ? 1 : 0)" class="px-6 py-4 text-center text-gray-500">
                Please select a vendor to view their invoices.
              </td>
            </tr> 
            <tr v-else-if="data.length==0">
              <td :colspan="columns.length + (showActions ? 1 : 0)" class="px-6 py-4 text-center text-gray-500">
                No invoices were found for the selected vendor
              </td>
            </tr>
          </tbody> 
        </table>
      </div> 
  </div>
</template>

<script setup>
  import { route } from "../../helpers/route"
  import { ref } from "vue"
  const venderIsSelected = ref(false);
  const columns = [
    {
      key:"vendor_name",
      label: "vendor_name",
    },
    {
      key:"vehicle",
      label: "vehicle",
    },
    {
      key:"total_payable",
      label: "total_payable",
      format: "currency",
    },
    {
      key:"commission_deduction",
      label: "commission_deduction",
      format: "currency",
    },
    {
      key:"extra_expenses",
      label: "extra_expenses",
      format: "currency",
    },
  ];

  const props = defineProps({
    data: {
      type: Array,
      required: true
    },
    rowKey: {
      type: String,
      required: false,
      default: "id"
    },
 
  })



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

</script>

<style scoped>
</style>

