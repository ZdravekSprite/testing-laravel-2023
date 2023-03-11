# Breeze

```bash
composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate:fresh
npm install && npm run dev
php artisan serve
```

- vue\app\Http\Controllers\Auth\AuthenticatedSessionController.php

```js
  public function create(): Response
  {
    return Inertia::render('Auth/Login', [
      'canRegister' => Route::has('register'),
      'canResetPassword' => Route::has('password.request'),
      'status' => session('status'),
    ]);
  }
```

- vue\resources\js\Pages\Auth\Login.vue

```js
defineProps({
  canRegister: Boolean,
  canResetPassword: Boolean,
  status: String,
});

      <div class="flex items-center justify-end mt-4 space-x-6">
        <Link v-if="canRegister" :href="route('register')"
          class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
        Not registered jet?
        </Link>
```
