# Components DeleteForm

- vue\resources\js\Components\DeleteForm.vue

```ts
<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import IconTrash from '@/Components/IconTrash.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  element: Object,
  destroyRoute: String,
});

const confirmingDeletion = ref(false);

const form = useForm({
  id: props.element.id,
});

const confirmDeletion = () => {
  confirmingDeletion.value = true;
};

const deleteElement = () => {
  form.delete(route(props.destroyRoute, props.element.id), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingDeletion.value = false;
};
</script>

<template>
  <div>
    <DangerButton @click="confirmDeletion">
      <IconTrash class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </DangerButton>

    <Modal :show="confirmingDeletion" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Are you sure you want to delete {{props.element.name ?? props.element.id + '. element'}}?
        </h2>
        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal">Cancel</SecondaryButton>

          <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="deleteElement">
            Delete
          </DangerButton>
        </div>
      </div>
    </Modal>
  </div>
</template>
```

- vue\resources\js\Components\IndexList.vue

```ts
<script setup>
import DeleteForm from '@/Components/DeleteForm.vue';

defineProps({
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
});
</script>

<template>
        <td v-if="actions.length" class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          <DeleteForm v-if="actions.includes('delete')" class="float-right" :element="e" :deleteRoute="(actionRoute + 'destroy')" />
        </td>
</template>
```
