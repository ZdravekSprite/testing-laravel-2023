<script setup>
import DeleteForm from '@/Components/DeleteForm.vue';
import EditForm from '@/Components/EditForm.vue';
const props = defineProps({
  labels: {
    type: Array,
    default: [],
  },
  elements: {
    type: Array,
    default: [],
  },
  actionRoute: {
    type: String,
    default: '',
  },
  actions: {
    type: Array,
    default: [],
  },
  protect: {
    type: Number,
    default: -1,
  },
  perPage: {
    type: Number,
    default: 15,
  },
});
</script>

<template>
  <table class="table-auto w-full">
    <thead v-if="elements.length" class="text-lg font-medium text-gray-900 dark:text-gray-100">
      <tr>
        <th v-if="elements[0].icon" class="w-8"></th>
        <th v-for="l in labels" :key="l.id">{{ l[0] }}</th>
        <th v-if="actions.length" :style="{ width: (actions.length * 60) + 'px' }">Actions</th>
      </tr>
    </thead>
    <thead v-else class="text-lg font-medium text-gray-900 dark:text-gray-100">
      <tr>
        <th>No elements</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(e, i) in elements" :key="e.id">
        <template v-if="i < perPage">
          <td v-if="elements[0].icon"><img v-if="e.icon" class="rounded-full shadow-xl" width="20" height="20"
              :src="e.icon" /></td>
          <td v-for="l in labels" :key="l.id" class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            <span v-if="l.length == 1">{{ e[l] }}</span>
            <span v-else>{{ e[l[0]] }}</span>
          </td>
          <td v-if="actions.length && i >= protect" class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            <EditForm v-if="actions.includes('edit')" class="float-left" :element="e"
              :updateRoute="(actionRoute + 'update')" :labels=labels />
            <DeleteForm v-if="actions.includes('delete')" class="float-right" :element="e"
              :destroyRoute="(actionRoute + 'destroy')" />
          </td>
        </template>
      </tr>
    </tbody>
  </table>
</template>
