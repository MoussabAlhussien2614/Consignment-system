<template>
    <Navbar>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
         <div>
          <h1 class="text-3xl font-bold text-gray-900">Consignment Items</h1>
          <p class="text-gray-600 mt-1">Manage your Consigned Products</p>
        </div>
        <ConsignmentItemTable :data="items"/>
      </div>
    </div>
  </Navbar>
  
</template>

<script setup>
import Navbar  from '../Navbar.vue'
import ConsignmentItemTable from './ConsignmentItemTable.vue';

defineProps({
  items:{
    type: Array,
    required: false,
    
  }
})


</script>

<style scoped>
</style>
