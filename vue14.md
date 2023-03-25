# Type

```bash
php artisan make:model Type -a
```

- vue\app\Models\Type.php

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

- vue\database\migrations\2023_03_25_150926_create_types_table.php

```php
    Schema::create('types', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('description')->nullable();
      $table->timestamps();
    });
```

```bash
php artisan migrate
```

- vue\database\seeders\TypeSeeder.php

```php
use App\Models\Type;
    if (!Type::where('name', 'unknown')->first()) {
      Type::create([
        'name' => 'unknown',
        'description' => 'Unknown type'
      ]);
    }
```

- vue\database\seeders\DatabaseSeeder.php

```php
    $this->call(TypeSeeder::class);
```

```bash
php artisan db:seed --class=TypeSeeder
```

- vue\resources\js\Pages\Type\Index.vue

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
  types: Array,
});

const types = ref(props.types)
const search = ref("")

watch(search, () => {
  types.value = props.types.filter(r => r.name.toString().includes(search.value))
})
</script>

<template>
  <Head title="Types" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <h2 class="p-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Types</h2>
        <NewForm :storeRoute="('type.store')" :labels="['name', 'description']" class="p-1" />
        <ImportForm class="p-1" />
        <ExportForm class="p-1" />
        <TextInput id="searchName" v-model.trim="search" type="text" class="block w-3/4" placeholder="Search name..." />
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <IndexList :elements="types" :labels="['name', 'description']" actionRoute="type."
            :actions="['edit', 'delete']" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
```

- vue\app\Http\Requests\StoreTypeRequest.php

```php
  public function authorize(): bool
  {
    return $this->user()->hasAnyRoles(['superadmin','admin','user']);
  }
  public function rules(): array
  {
    return [
      'name' => ['string', 'max:255', 'unique:types'],
      'description' => ['nullable', 'string', 'max:255'],
    ];
  }
```

- vue\app\Http\Requests\UpdateTypeRequest.php

```php
use App\Models\Type;
use Illuminate\Validation\Rule;
  public function authorize(): bool
  {
    return Type::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }
  public function rules(): array
  {
    return [
      'name' => ['string', 'max:255', Rule::unique(Type::class)->ignore($this->id)],
      'description' => ['nullable', 'string', 'max:255'],
    ];
  }
```

- vue\app\Http\Requests\DestroyTypeRequest.php

```php
<?php

namespace App\Http\Requests;

use App\Models\Type;
use Illuminate\Foundation\Http\FormRequest;

class DestroyTypeRequest extends FormRequest
{
  public function authorize(): bool
  {
    return Type::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }
  public function rules(): array
  {
    return [
      //
    ];
  }
}
```

- vue\app\Http\Controllers\TypeController.php

```php
use Inertia\Inertia;
  public function index()
  {
    return Inertia::render(
      'Type/Index',
      [
        'types' => Type::all(),
      ]
    );
  }
  public function store(StoreTypeRequest $request)
  {
    $type = new Type();
    $type->name = $request->name;
    $type->description = $request->description;
    $type->save();
  }
  public function update(UpdateRoleRequest $request, Role $role)
  {
    $role->name = $request->name;
    $role->description = $request->description;
    $role->save();
  }
  public function destroy(DestroyRoleRequest $request, Type $type)
  {
    dd($request);
    $type->delete();
  }
```

- vue\routes\web.php

```php
use App\Http\Controllers\TypeController;
  Route::get('/types', [TypeController::class, 'index'])->name('type.index');
  Route::post('/type', [TypeController::class, 'store'])->name('type.store');
  Route::patch('/type/{type}', [TypeController::class, 'update'])->name('type.update');
  Route::delete('/type/{type}', [TypeController::class, 'destroy'])->name('type.destroy');
```

- vue\resources\js\Layouts\AuthenticatedLayout.vue

```ts
              <!-- Navigation Links -->
                <NavLink v-if="isAuth" :href="route('type.index')" :active="route().current('type.index')">
                  Types
                </NavLink>
        <!-- Responsive Navigation Menu -->
            <ResponsiveNavLink v-if="isAuth" :href="route('type.index')" :active="route().current('type.index')">
              Type
            </ResponsiveNavLink>
```
