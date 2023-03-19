# Impersonate

- vue\resources\js\Pages\User\Partials\ImpersonateUser.vue

```ts
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
```

- vue\resources\js\Pages\User\Index.vue

```ts
<script setup>
import ImpersonateUser from './Partials/ImpersonateUser.vue';
</script>

<template>
              <tr v-for="u in users" :key="u.id">
                  <ImpersonateUser class="float-left" :user="u" />
              </tr>
</template>
```

- vue\resources\js\Layouts\AuthenticatedLayout.vue

```php
const isImpersonating = usePage().props.impersonate.id;
              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <NavLink v-if="isImpersonating" :href="route('user.stop')" :active="isImpersonating">
                  Stop
                </NavLink>
              </div>
        <!-- Responsive Navigation Menu -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink v-if="isImpersonating" :href="route('user.stop')" :active="isImpersonating">
              Role
            </ResponsiveNavLink>
          </div>
```

- vue\app\Http\Middleware\HandleInertiaRequests.php

```php
      'impersonate' => [
        'id' => session()->get('impersonate'),
      ],
```

- vue\routes\web.php

```php
Route::get('/user/stop', [UserController::class, 'stop'])->name('user.stop');
Route::middleware('auth.admin')->group(function () {
  Route::get('/user/{user}', [UserController::class, 'start'])->name('user.start');
});
```

- vue\app\Http\Controllers\UserController.php

```php
  /**
   * Impersonate
   */
  public function start(User $user)
  {
    $originalId = auth()->user()->id;
    session()->put('impersonate', $originalId);
    auth()->loginUsingId($user->id);
    //dd($user->id,session()->get('impersonate'),auth()->user());
    return redirect()->route('dashboard');
  }
  public function stop()
  {
    $originalId = session()->get('impersonate');
    auth()->loginUsingId($originalId);
    session()->forget('impersonate');
    return redirect(route('user.index'));
  }
```
