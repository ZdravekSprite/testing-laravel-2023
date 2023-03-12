# Role

```bash
php artisan make:model Role -a
```

- vue\app\Models\Role.php

```php
  public function users()
  {
    return $this->belongsToMany(User::class);
  }
```

- vue\app\Models\User.php

```php
  public function roles()
  {
    return $this->belongsToMany(Role::class);
  }

  public function hasAnyRoles($roles)
  {
    return null !== $this->roles()->whereIn('name', $roles)->first();
  }

  public function hasAnyRole($role)
  {
    return null !== $this->roles()->where('name', $role)->first();
  }
```

- vue\database\migrations\2023_03_11_093402_create_roles_table.php

```php
  public function up(): void
  {
    Schema::create('roles', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('icon');
      $table->timestamps();
    });
    Schema::create('role_user', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->foreignId('role_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->timestamps();
    });
  }
  public function down()
  {
    Schema::dropIfExists('roles');
    Schema::dropIfExists('role_user');
  }
```

```bash
php artisan migrate
```

- vue\database\seeders\RoleSeeder.php

```php
use App\Models\Role;
  public function run(): void
  {
    Role::truncate();
    Role::create(['name' => 'superadmin', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/5/55/User-admin-gear.svg']);
    Role::create(['name' => 'admin', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_1.svg']);
    Role::create(['name' => 'user', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Blank_user.svg']);
    Role::create(['name' => 'socialuser', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_2.svg']);
    Role::create(['name' => 'blockeduser', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/0/0a/Gnome-stock_person.svg']);
    DB::table('role_user')->truncate();
    $superadminRole = Role::where('name', 'superadmin')->first();
    $adminRole = Role::where('name', 'admin')->first();
    $super_admin = User::create([
      'name' => env('SUPER_ADMIN_NAME', 'Super Admin'),
      'email' =>  env('SUPER_ADMIN_EMAIL', 'super@admin.com'),
      'password' => Hash::make(env('SUPER_ADMIN_PASS', 'password'))
    ]);
    $super_admin->roles()->attach($superadminRole);
    $super_admin->roles()->attach($adminRole);
  }
```

- vue\database\seeders\DatabaseSeeder.php

```php
  public function run(): void
  {
    $this->call(RoleSeeder::class);
  }
```

- vue/.env

```ts
SUPER_ADMIN_NAME="Super Admin"
SUPER_ADMIN_EMAIL=super@admin.com
SUPER_ADMIN_PASS=password
```

```bash
php artisan db:seed --class=RoleSeeder
```

- vue\resources\js\Pages\Profile\Partials\RoleInformation.vue

```js
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
```

```js
import RoleInformation from './Partials/RoleInformation.vue';
defineProps({
  roles: Array,
  mustVerifyEmail: Boolean,
  status: String,
});
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <RoleInformation :roles="roles" class="max-w-xl" />
        </div>
```

- vue\app\Http\Controllers\ProfileController.php

```php
  public function edit(Request $request): Response
  {
    return Inertia::render('Profile/Edit', [
      'roles' => $request->user()->roles,
    ]);
  }
```

- vue\app\Http\Controllers\RoleController.php

```php
use Inertia\Inertia;
  public function index()
  {
    return Inertia::render(
      'Role/Index',
      [
        'roles' => Role::all(),
      ]
    );
  }
```

- vue\routes\web.php

```php
use App\Http\Controllers\RoleController;
Route::middleware('auth')->group(function () {
  Route::get('/role', [RoleController::class, 'index'])->name('role.index');
});
```

- vue\resources\js\Layouts\AuthenticatedLayout.vue

```php
              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <NavLink :href="route('role.index')" :active="route().current('role.index')">
                  Role
                </NavLink>
              </div>
        <!-- Responsive Navigation Menu -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink :href="route('role.index')" :active="route().current('role.index')">
              Role
            </ResponsiveNavLink>
          </div>
```

- vue\resources\js\Pages\Role\Index.vue

```php
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
defineProps({
  roles: Array,
});
</script>

<template>
  <Head title="Roles" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Roles</h2>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <table class="table-auto w-full">
            <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
              <tr>
                <th>Role</th>
              </tr>
            </thead>
            <tbody>
              <tr
              v-for="r in roles"
              :key="r.id">
                <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{r.name}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
```
