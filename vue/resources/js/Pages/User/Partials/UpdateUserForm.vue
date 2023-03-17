<script setup>
import IconPen from '@/Components/IconPen.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const props = defineProps({
  user: Object,
});

const confirmingUserUpdate = ref(false);

const form = useForm({
  id: props.user.id,
  name: props.user.name,
  email: props.user.email,
});

const confirmUserUpdate = () => {
  confirmingUserUpdate.value = true;
};

const updateUser = () => {
  form.patch(route('user.update'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingUserUpdate.value = false;

  form.reset();
};
</script>

<template>
  <div>
    <SecondaryButton @click="confirmUserUpdate">
      <IconPen class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </SecondaryButton>

    <Modal :show="confirmingUserUpdate" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          User Information
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          Update user account's information.
        </p>

        <div class="mt-6">
          <InputLabel for="name" value="Name" />
          <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
            autocomplete="name" />
          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="mt-6">
          <InputLabel for="email" value="Email" />
          <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
            autocomplete="username" />
          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
          <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="updateUser">
            Update Account
          </PrimaryButton>
        </div>
      </div>
    </Modal>
  </div>
</template>
