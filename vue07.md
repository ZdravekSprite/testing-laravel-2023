# Components EditForm

- vue\resources\js\Components\EditForm.vue

```ts
<script setup>
import IconPen from '@/Components/IconPen.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  element: Object,
  updateRoute: String,
  labels: Array,
});

const frmObj = {};
for (let i = 0; i < props.labels.length; i++) {
  frmObj[props.labels[i]] = props.element[props.labels[i]];
}
frmObj['id'] = props.element['id'];
const confirmingUpdate = ref(false);

const form = useForm(frmObj);

const confirmUpdate = () => {
  confirmingUpdate.value = true;
};

const update = () => {
  form.patch(route(props.updateRoute, props.element.id), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingUpdate.value = false;
};
</script>

<template>
  <div>
    <SecondaryButton @click="confirmUpdate">
      <IconPen class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </SecondaryButton>

    <Modal :show="confirmingUpdate" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Edit {{ props.element.name ?? props.element.id + '. element' }}?
        </h2>
        <div v-for="l in labels" :key="l" class="mt-6">
          <InputLabel :for="l" :value="l.replace(/\b(\S)/g, (t) => { return t.toUpperCase() })" />
          <TextInput :id="l" v-model="form[l]" type="text" class="mt-1 block w-3/4"
            :placeholder="l" />
          <InputError :message="form.errors[l]" class="mt-2" />
        </div>
        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
          <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="update">
            Update Element
          </PrimaryButton>
        </div>
      </div>
    </Modal>
  </div>
</template>
```

- vue\resources\js\Components\IndexList.vue

```ts
<script setup>
import EditForm from '@/Components/EditForm.vue';

defineProps({
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
});
</script>

<template>
        <td v-if="actions.length && e.id > 1" class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          <EditForm v-if="actions.includes('edit')" class="float-left" :element="e" :updateRoute="(actionRoute + 'update')" :labels=labels />
        </td>
</template>
```
