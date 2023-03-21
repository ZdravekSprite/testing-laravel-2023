<script setup>
defineProps({
  labels: {
    type: Array,
    default: [],
  },
  elements: {
    type: Array,
    default: [],
  },
});
</script>

<template>
  <table class="table-auto w-full">
    <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
      <tr>
        <th v-if="elements[0].icon" class="w-8"></th>
        <th v-for="l in labels" :key="l.id">{{ l }}</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="e in elements" :key="e.id">
        <td v-if="e.icon"><img class="rounded-full shadow-xl" width="20" height="20" :src="e.icon" /></td>
        <td v-for="l in labels" :key="l.id" class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          {{ e[l] }}
        </td>
      </tr>
    </tbody>
  </table>
</template>
