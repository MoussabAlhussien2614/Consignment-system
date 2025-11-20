<template>
  <Navbar>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Invoice Items</h1>
          <p class="text-gray-600 mt-1"></p>
        </div>
        <InvoiceItemTable :data="items"/>
        
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Invoice Footer</h1>
          <p class="text-gray-600 mt-1"></p>
        </div>
          
        <InvoiceTable :data="[invoice]" :with-actions="false"/>
        </div>
      </div>
  </Navbar>
  
</template>

<script setup>
import Navbar  from '../Navbar.vue'
import InvoiceTable from './InvoiceTable.vue';
import InvoiceItemTable from './InvoiceItemTable.vue';

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
  invoice: {
    type: Array,
    required: true,
  },
})



</script>

<style scoped>
</style>
