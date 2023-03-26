<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import IndexList from '@/Components/IndexList.vue';
import NewForm from '@/Components/NewForm.vue';
import ImportForm from '@/Components/ImportForm.vue';
import ExportForm from '@/Components/ExportForm.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, watch } from "vue"
const props = defineProps({
  types: Array,
});

const types = ref(props.types)
const search = ref("")

watch(search, () => {
  types.value = props.types.filter(r => r.name.toString().includes(search.value))
})
</script>

<template>
  <Head title="Types" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <h2 class="p-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Types</h2>
        <NewForm :storeRoute="('type.store')" :labels="[['name'], ['description']]" class="p-1" />
        <ImportForm class="p-1" />
        <ExportForm :elements="types" fileName="types.csv" class="p-1" />
        <TextInput id="searchName" v-model.trim="search" type="text" class="block w-3/4" placeholder="Search name..." />
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <IndexList :elements="types" :labels="['name', 'description']" actionRoute="type."
            :actions="['edit', 'delete']" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
