<template>
    <Navbar>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        Consignment
        Consignment
        Consignment
        Consignment
    </main>
  </Navbar>
  
</template>

<script setup>
import Navbar  from '../Navbar.vue'

defineProps({
  user: {
    type: Object,
    required: true,
  },
})


</script>

<style scoped>
</style>
