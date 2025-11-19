<template>
  <Navbar>
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Invoices</h1>
          <p class="text-gray-600 mt-1">Generate Invoices for your Vendors</p>
        </div>
        <InvoiceTable :data="data"/>
      </div>
    </div>
  </Navbar>
  
</template>

<script setup>
import Navbar  from '../Navbar.vue'
import InvoiceTable from './InvoiceTable.vue';

const props = defineProps({
  data: {
    type: Array,
    required: true,
  },
  thing1: {
    type: String,
    required: true,
  },
})

</script>

<style scoped>
</style>
