<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import IndexList from '@/Components/IndexList.vue';
import NewForm from '@/Components/NewForm.vue';
import ImportForm from '@/Components/ImportForm.vue';
import ExportForm from '@/Components/ExportForm.vue';
import { Link, Head } from '@inertiajs/vue3';
const props = defineProps({
  devices: Object,
  types: Array,
  warehouses: Array,
  owners: Array,
});
</script>

<template>
  <Head title="Devices" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <h2 class="p-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Devices</h2>
        <NewForm :storeRoute="('device.store')"
          :labels="[['imei'], ['gsm'], ['type', props.types], ['warehouse', props.warehouses], ['owner', props.owners], ['description']]"
          class="p-1" />
        <ImportForm fileName="devices.csv" model="Device" class="p-1" />
        <ExportForm :elements="props.devices.data" fileName="devices.csv" class="p-1" />
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <SecondaryButton v-for="t in types" :key="t.id">
            <Link :href="route('device.index', t.name)">{{ t.name }}</Link>
          </SecondaryButton>
          <IndexList :protect=-1 :elements="props.devices.data"
            :labels="[['imei'], ['gsm'], ['type', 'type_id', props.types], ['warehouse', 'warehouse_id', props.warehouses], ['owner', 'owner_id', props.owners], ['description']]"
            actionRoute="device." :actions="['edit', 'delete']" />
          <SecondaryButton v-for="l in props.devices.links" :key="l.id">
            <Link :href="l.url" v-html="l.label" />
          </SecondaryButton>
        </div>
      </div>
  </div>
</AuthenticatedLayout></template>
