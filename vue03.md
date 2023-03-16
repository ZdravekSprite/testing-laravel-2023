# Users

```bash
php artisan make:controller UserController -mUser
```

- vue\app\Http\Controllers\UserController.php

```php
use Inertia\Inertia;
  public function index()
  {
    $users = User::all()->map(function ($user) {
      $roles = $user->roles()->get();
      $user['roles'] = $roles;
      return $user;
    });
    return Inertia::render(
      'User/Index',
      [
        'users' => $users->toArray(),
      ]
    );
  }
  public function destroy(Request $request)
  {
    $request->validate([
      'password' => ['required', 'current-password'],
    ]);
    $user = User::findOrFail($request->id);;
    $user->delete();
  }
```

- vue\routes\web.php

```php
use App\Http\Controllers\UserController;
Route::middleware('auth.admin')->group(function () {
  Route::get('/user', [UserController::class, 'index'])->name('user.index');
  Route::delete('/user', [UserController::class, 'destroy'])->name('user.destroy');
});
```

- vue\resources\js\Components\IconPen.vue

```ts
<template>
  <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
  </svg>
</template>
```

- vue\resources\js\Components\IconPerson.vue

```ts
<template>
  <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
  </svg>
</template>
```

- vue\resources\js\Components\IconTrash.vue

```ts
<template>
  <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
    <path fill-rule="evenodd"
      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
  </svg>
</template>
```

- vue\resources\js\Pages\User\Partials\DeleteUserForm.vue

```ts
<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import IconTrash from '@/Components/IconTrash.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const props = defineProps({
  user: Object,
});

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const authUser = usePage().props.auth.user;

const form = useForm({
  password: '',
  id: props.user.id,
});

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true;

  nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
  form.delete(route('user.destroy'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingUserDeletion.value = false;

  form.reset();
};
</script>

<template>
  <div v-if="props.user.id !== authUser.id">
    <DangerButton class="float-right" @click="confirmUserDeletion">
      <IconTrash class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </DangerButton>

    <Modal :show="confirmingUserDeletion" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Are you sure you want to delete account?
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          Once account is deleted, all of its resources and data will be permanently deleted.
          Please enter your password to confirm you would like to permanently delete account.
        </p>

        <div class="mt-6">
          <InputLabel for="password" value="Password" class="sr-only" />

          <TextInput id="password" ref="passwordInput" v-model="form.password" type="password" class="mt-1 block w-3/4"
            placeholder="Password" @keyup.enter="deleteUser" />

          <InputError :message="form.errors.password" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

          <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="deleteUser">
            Delete Account
          </DangerButton>
        </div>
      </div>
    </Modal>
  </div>
</template>
```

- vue\resources\js\Pages\User\Index.vue

```ts
<script setup>
import IconPen from '@/Components/IconPen.vue';
import IconPerson from '@/Components/IconPerson.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
  users: Array,
});
</script>

<template>
  <Head title="Users" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Users</h2>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <table class="table-auto w-full">
            <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="u in users" :key="u.id">
                <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ u.name }}</td>
                <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ u.email }}</td>
                <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ u.roles.map(e => e.name).join(', ') }}</td>
                <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                  <SecondaryButton class="float-left">
                    <IconPen class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
                  </SecondaryButton>
                  <SecondaryButton class="float-left">
                    <IconPerson class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
                  </SecondaryButton>
                  <DeleteUserForm class="max-w-xl" :user="u" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
```

- vue\resources\js\Layouts\AuthenticatedLayout.vue

```ts
              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <NavLink v-if="isadmin" :href="route('user.index')" :active="route().current('user.index')">
                  User
                </NavLink>
        <!-- Responsive Navigation Menu -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink v-if="isadmin" :href="route('user.index')" :active="route().current('user.index')">
              User
            </ResponsiveNavLink>
```
