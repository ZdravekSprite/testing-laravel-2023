<script setup>
const props = defineProps({
  roles: Array,
});
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Role Information</h2>

      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
      <div v-for="r in roles" :key="r.id">
        {{ r.name }}
      </div>
      </p>
    </header>
  </section>
</template>
