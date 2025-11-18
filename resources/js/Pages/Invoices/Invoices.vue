<template>
  <Navbar>

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
