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
                <div v-else-if="column.format === 'rate'" class="text-sm font-medium text-gray-900">
                  %{{ formatCurrency(getNestedValue(row, column.key)) }}
                </div>
                <div v-else :class="column.class || 'text-sm text-gray-900'">
                  {{ getNestedValue(row, column.key) || column.defaultValue || '-' }}
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
      key:"price",
      label: "price",
      format: "currency",
    },
    {
      key:"quantity",
      label: "quantity",
    },
    {
      key:"extra_expenses",
      label: "extra_expenses",
      format: "currency",
    },
    {
      key:"commission",
      label: "commission_rate",
      format: "rate"
    },
  
    {
      key:"time_sold",
      label: "sold_at",
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

  function formatCurrency(value) {
    return parseFloat(value || 0).toFixed(2)
  }

</script>

<style scoped>
</style>

