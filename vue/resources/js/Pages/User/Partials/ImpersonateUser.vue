<script setup>
import IconPerson from '@/Components/IconPerson.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
  user: Object,
});

const authUser = usePage().props.auth.user;
</script>

<template>
  <div v-if="props.user.id !== authUser.id">
    <SecondaryButton>
      <IconPerson class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </SecondaryButton>
  </div>
</template>
