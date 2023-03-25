<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  storeRoute: String,
  labels: Array,
});

const confirmingStore = ref(false);

const frmObj = {};
for (let i = 0; i < props.labels.length; i++) {
  frmObj[props.labels[i]] = "";
}
const form = useForm(frmObj);

const confirmStore = () => {
  confirmingStore.value = true;
};

const create = () => {
  form.post(route(props.storeRoute), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingStore.value = false;
  form.reset();
};
</script>

<template>
  <div>
    <SecondaryButton @click="confirmStore">
      New
    </SecondaryButton>

    <Modal :show="confirmingStore" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          New?
        </h2>
        <div v-for="l in labels" :key="l" class="mt-6">
          <InputLabel :for="l" :value="l.replace(/\b(\S)/g, (t) => { return t.toUpperCase() })" />
          <TextInput :id="l" v-model="form[l]" type="text" class="mt-1 block w-3/4" :placeholder="l" />
          <InputError :message="form.errors[l]" class="mt-2" />
        </div>
        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
          <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="create">
            Create
          </PrimaryButton>
        </div>
      </div>
    </Modal>
  </div>
</template>
