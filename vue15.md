# Warehouse

```bash
php artisan make:model Warehouse -a
```

- vue\app\Models\Warehouse.php

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

- vue\database\migrations\2023_03_26_074651_create_warehouses_table.php

```php
    Schema::create('warehouses', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('description')->nullable();
      $table->timestamps();
    });
```

```bash
php artisan migrate
```

- vue\database\seeders\WarehouseSeeder.php

```php
use App\Models\Warehouse;
    if (!Warehouse::where('name', 'unknown')->first()) {
      Warehouse::create([
        'name' => 'unknown',
        'description' => 'Unknown type'
      ]);
    }
```

- vue\database\seeders\DatabaseSeeder.php

```php
    $this->call(WarehouseSeeder::class);
```

```bash
php artisan db:seed --class=WarehouseSeeder
```

- vue\resources\js\Pages\Warehouse.vue

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
  warehouses: Array,
});

const warehouses = ref(props.warehouses)
const search = ref("")

watch(search, () => {
  warehouses.value = props.warehouses.filter(w => w.name.toString().includes(search.value))
})
</script>

<template>
  <Head title="Warehouses" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <h2 class="p-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Warehouses</h2>
        <NewForm :storeRoute="('warehouse.store')" :labels="['name', 'description']" class="p-1" />
        <ImportForm class="p-1" />
        <ExportForm :elements="warehouses" class="p-1" />
        <TextInput id="searchName" v-model.trim="search" type="text" class="block w-3/4" placeholder="Search name..." />
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <IndexList :elements="warehouses" :labels="['name', 'description']" actionRoute="warehouse."
            :actions="['edit', 'delete']" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
```

- vue\app\Http\Requests\StoreWarehouseRequest.php

```php
  public function authorize(): bool
  {
    return $this->user()->hasAnyRoles(['superadmin','admin','user']);
  }
  public function rules(): array
  {
    return [
      'name' => ['string', 'max:255', 'unique:warehouses'],
      'description' => ['nullable', 'string', 'max:255'],
    ];
  }
```

- vue\app\Http\Requests\UpdateWarehouseRequest.php

```php
use App\Models\Warehouse;
use Illuminate\Validation\Rule;
  public function authorize(): bool
  {
    return Warehouse::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }
  public function rules(): array
  {
    return [
      'name' => ['string', 'max:255', Rule::unique(Warehouse::class)->ignore($this->id)],
      'description' => ['nullable', 'string', 'max:255'],
    ];
  }
```

- vue\app\Http\Requests\DestroyWarehouseRequest.php

```php
<?php

namespace App\Http\Requests;

use App\Models\Warehouse;
use Illuminate\Foundation\Http\FormRequest;

class DestroyWarehouseRequest extends FormRequest
{
  public function authorize(): bool
  {
    return Warehouse::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }
  public function rules(): array
  {
    return [
      //
    ];
  }
}
```

- vue\app\Http\Controllers\WarehouseController.php

```php
use App\Http\Requests\DestroyWarehouseRequest;
use Inertia\Inertia;
  public function index()
  {
    return Inertia::render(
      'Warehouse',
      [
        'warehouses' => Warehouse::all(),
      ]
    );
  }
  public function store(StoreWarehouseRequest $request)
  {
    $warehouse = new Warehouse();
    $warehouse->name = $request->name;
    $warehouse->description = $request->description;
    $warehouse->save();
  }
  public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
  {
    $warehouse->name = $request->name;
    $warehouse->description = $request->description;
    $warehouse->save();
  }
  public function destroy(DestroyWarehouseRequest $request, Warehouse $warehouse)
  {
    $warehouse->delete();
  }
```

- vue\routes\web.php

```php
use App\Http\Controllers\WarehouseController;
  Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouse.index');
  Route::post('/warehouse', [WarehouseController::class, 'store'])->name('warehouse.store');
  Route::patch('/warehouse/{warehouse}', [WarehouseController::class, 'update'])->name('warehouse.update');
  Route::delete('/warehouse/{warehouse}', [WarehouseController::class, 'destroy'])->name('warehouse.destroy');
```

- vue\resources\js\Layouts\AuthenticatedLayout.vue

```ts
              <!-- Navigation Links -->
                <NavLink v-if="isAuth" :href="route('warehouse.index')" :active="route().current('warehouse.index')">
                  Warehouses
                </NavLink>
        <!-- Responsive Navigation Menu -->
            <ResponsiveNavLink v-if="isAuth" :href="route('warehouse.index')" :active="route().current('warehouse.index')">
              Warehouses
            </ResponsiveNavLink>
```
