<template>
  <Navbar>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Invoices</h1>
          <p class="text-gray-600 mt-1">Generate invoices for your vendors</p>
        </div>
          <div class="flex items-center gap-2">
            <div class="w-full">
              <FormSelect
              id="vendor_id"
              label=""
              :options="vendorOptions"
              v-model="form.vendor_id"
              placeholder="Select a vendor"
              :error="form.errors.vendor_id"
              />
            </div>
            <div class="w-full">
              <FormInput
                id="from_date"
                v-model="form.from_date"
                type="date"
                placeholder="From Date"
                :error="form.errors.from_date"
                :max="todayMax"
              />
            </div>
            <div >
              To
            </div>
            <div class="w-full">
              <FormInput
                id="to_date"
                v-model="form.to_date"
                type="date"
                placeholder="To Date"
                :error="form.errors.to_date"
                :max="todayMax"
              />
            </div>
            <button class="block px-5 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-green-200 text-gray-900" @click.prevent="generateInvoices">
              Generate
            </button>
          </div>
          <InvoiceTable :data="data"/>
        </div>
      </div>
  </Navbar>
  
</template>

<script setup>
import Navbar  from '../Navbar.vue'
import FormSelect from '../../Components/FormSelect.vue'
import FormInput from '../../Components/FormInput.vue'
import InvoiceTable from './InvoiceTable.vue';
import { computed } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { route } from '../../helpers/route';

const props = defineProps({
  data: {
    type: Array,
    required: true,
  },
  vendors: {
    type: Array,
    required: true,
  },
})

const form = useForm({
  vendor_id: "",
  from_date: "",
  to_date: "",
})

const todayMax = computed(() => {
  const now = new Date()
  const year = now.getFullYear()
  const month = String(now.getMonth() + 1).padStart(2, '0')
  const day = String(now.getDate()).padStart(2, '0')
  const hours = String(now.getHours()).padStart(2, '0')
  const minutes = String(now.getMinutes()).padStart(2, '0')
  
  return `${year}-${month}-${day}T${hours}:${minutes}`
})

const vendorOptions = computed(() => {
  return props.vendors.map(v => ({value:v.id,label: v.name}));
})

const generateInvoices = () => {
  router.get(route("invoices"),{
    vendor_id: form.vendor_id,
    from_date: form.from_date,
    to_date: form.to_date,
  })
}

</script>

<style scoped>
</style>
