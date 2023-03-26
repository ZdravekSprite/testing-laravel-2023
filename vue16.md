# Owner

```bash
php artisan make:model Owner -a
```

- vue\app\Models\Owner.php

```php
  protected $hidden = [
    'created_at',
    'updated_at',
  ];
  protected $fillable = [
    'name',
    'description',
  ];
```

- vue\database\migrations\2023_03_26_083303_create_owners_table.php

```php
    Schema::create('owners', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('description')->nullable();
      $table->timestamps();
    });
```

```bash
php artisan migrate
```

- vue\database\seeders\OwnerSeeder.php

```php
use App\Models\Owner;
    if (!Owner::where('name', 'unknown')->first()) {
      Owner::create([
        'name' => 'unknown',
        'description' => 'Unknown type'
      ]);
    }
```

- vue\database\seeders\DatabaseSeeder.php

```php
    $this->call(OwnerSeeder::class);
```

```bash
php artisan db:seed --class=OwnerSeeder
```

- vue\resources\js\Pages\Owner.vue

```ts
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import IndexList from '@/Components/IndexList.vue';
import NewForm from '@/Components/NewForm.vue';
import ImportForm from '@/Components/ImportForm.vue';
import ExportForm from '@/Components/ExportForm.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head } from '@inertiajs/vue3';
import { ref, watch } from "vue"
const props = defineProps({
  owners: Array,
});

const owners = ref(props.owners)
const search = ref("")

watch(search, () => {
  owners.value = props.owners.filter(w => w.name.toString().includes(search.value))
})
</script>

<template>
  <Head title="Owners" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <h2 class="p-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Owners</h2>
        <NewForm :storeRoute="('owner.store')" :labels="['name', 'description']" class="p-1" />
        <ImportForm class="p-1" />
        <ExportForm :elements="owners" class="p-1" />
        <TextInput id="searchName" v-model.trim="search" type="text" class="block w-3/4" placeholder="Search name..." />
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <IndexList :elements="owners" :labels="['name', 'description']" actionRoute="owner."
            :actions="['edit', 'delete']" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
```

- vue\app\Http\Requests\StoreOwnerRequest.php

```php
  public function authorize(): bool
  {
    return $this->user()->hasAnyRoles(['superadmin','admin','user']);
  }
  public function rules(): array
  {
    return [
      'name' => ['string', 'max:255', 'unique:owners'],
      'description' => ['nullable', 'string', 'max:255'],
    ];
  }
```

- vue\app\Http\Requests\UpdateOwnerRequest.php

```php
use App\Models\Owner;
use Illuminate\Validation\Rule;
  public function authorize(): bool
  {
    return Owner::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }
  public function rules(): array
  {
    return [
      'name' => ['string', 'max:255', Rule::unique(Owner::class)->ignore($this->id)],
      'description' => ['nullable', 'string', 'max:255'],
    ];
  }
```

- vue\app\Http\Requests\DestroyOwnerRequest.php

```php
<?php

namespace App\Http\Requests;

use App\Models\Owner;
use Illuminate\Foundation\Http\FormRequest;

class DestroyOwnerRequest extends FormRequest
{
  public function authorize(): bool
  {
    return Owner::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }
  public function rules(): array
  {
    return [
      //
    ];
  }
}
```

- vue\app\Http\Controllers\OwnerController.php

```php
use App\Http\Requests\DestroyOwnerRequest;
use Inertia\Inertia;
  public function index()
  {
    return Inertia::render(
      'Owner',
      [
        'owners' => Owner::all(),
      ]
    );
  }
  public function store(StoreOwnerRequest $request)
  {
    $owner = new Owner();
    $owner->name = $request->name;
    $owner->description = $request->description;
    $owner->save();
  }
  public function update(UpdateOwnerRequest $request, Owner $owner)
  {
    $owner->name = $request->name;
    $owner->description = $request->description;
    $owner->save();
  }
  public function destroy(DestroyOwnerRequest $request, Owner $owner)
  {
    $owner->delete();
  }
```

- vue\routes\web.php

```php
use App\Http\Controllers\OwnerController;
  Route::get('/owners', [OwnerController::class, 'index'])->name('owner.index');
  Route::post('/owner', [OwnerController::class, 'store'])->name('owner.store');
  Route::patch('/owner/{owner}', [OwnerController::class, 'update'])->name('owner.update');
  Route::delete('/owner/{owner}', [OwnerController::class, 'destroy'])->name('owner.destroy');
```

- vue\resources\js\Layouts\AuthenticatedLayout.vue

```ts
              <!-- Navigation Links -->
                <NavLink v-if="isAuth" :href="route('owner.index')" :active="route().current('owner.index')">
                  Owners
                </NavLink>
        <!-- Responsive Navigation Menu -->
            <ResponsiveNavLink v-if="isAuth" :href="route('owner.index')" :active="route().current('owner.index')">
              Owners
            </ResponsiveNavLink>
```
