# Config

```bash
php artisan make:model Config -a
```

- vue\database\migrations\2023_03_27_183425_create_configs_table.php

```php
    Schema::create('configs', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('description')->nullable();
      $table->timestamps();
    });
```

```bash
php artisan migrate
```

- vue\database\seeders\ConfigSeeder.php

```php
use App\Models\Config;
    if (!Config::where('name', 'unknown')->first()) {
      Config::create([
        'name' => 'unknown',
        'description' => 'Unknown configuration'
      ]);
    }
```

- vue\database\seeders\DatabaseSeeder.php

```php
    $this->call(ConfigSeeder::class);
```

```bash
php artisan db:seed --class=ConfigSeeder
```

- vue\app\Models\Config.php

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

- vue\resources\js\Pages\Config.vue

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
  configs: Array,
});

const configs = ref(props.configs)
const search = ref("")

watch(search, () => {
  configs.value = props.configs.filter(c => c.name.toString().toLowerCase().includes(search.value.toLowerCase()))
})
</script>

<template>
  <Head title="Configs" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <h2 class="p-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Configs</h2>
        <NewForm :storeRoute="('config.store')" :labels="[['name'], ['description']]" class="p-1" />
        <ImportForm class="p-1" />
        <ExportForm :elements="configs" fileName="configs.csv" class="p-1" />
        <TextInput id="searchName" v-model.trim="search" type="text" class="block w-3/4" placeholder="Search name..." />
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <IndexList :elements="configs" :protect=15 :perPage=15 :labels="['name', 'description']" actionRoute="config."
            :actions="['edit', 'delete']" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
```

- vue\app\Http\Requests\StoreConfigRequest.php

```php
  public function authorize(): bool
  {
    return $this->user()->hasAnyRoles(['superadmin','admin','user']);
  }
  public function rules(): array
  {
    return [
      'name' => ['string', 'max:255', 'unique:Configs'],
      'description' => ['nullable', 'string', 'max:255'],
    ];
  }
```

- vue\app\Http\Requests\UpdateConfigRequest.php

```php
use App\Models\Config;
use Illuminate\Validation\Rule;
  public function authorize(): bool
  {
    return Config::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }
  public function rules(): array
  {
    return [
      'name' => ['string', 'max:255', Rule::unique(Config::class)->ignore($this->id)],
      'description' => ['nullable', 'string', 'max:255'],
    ];
  }
```

- vue\app\Http\Requests\DestroyConfigRequest.php

```php
<?php

namespace App\Http\Requests;

use App\Models\Config;
use Illuminate\Foundation\Http\FormRequest;

class DestroyConfigRequest extends FormRequest
{
  public function authorize(): bool
  {
    return Config::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }
  public function rules(): array
  {
    return [
      //
    ];
  }
}
```

- vue\app\Http\Controllers\ConfigController.php

```php
use App\Http\Requests\DestroyConfigRequest;
use Inertia\Inertia;
  public function index()
  {
    return Inertia::render(
      'Config',
      [
        'configs' => Config::all(),
      ]
    );
  }
  public function store(StoreConfigRequest $request)
  {
    $config = new Config();
    $config->name = $request->name;
    $config->description = $request->description;
    $config->save();
  }
  public function update(UpdateConfigRequest $request, Config $config)
  {
    $config->name = $request->name;
    $config->description = $request->description;
    $config->save();
  }
  public function destroy(DestroyConfigRequest $request, Config $config)
  {
    $config->delete();
  }
```

- vue\routes\web.php

```php
use App\Http\Controllers\ConfigController;
  Route::get('/configs', [ConfigController::class, 'index'])->name('config.index');
  Route::post('/config', [ConfigController::class, 'store'])->name('config.store');
  Route::patch('/config/{config}', [ConfigController::class, 'update'])->name('config.update');
  Route::delete('/config/{config}', [ConfigController::class, 'destroy'])->name('config.destroy');
```

- vue\resources\js\Layouts\AuthenticatedLayout.vue

```ts
              <!-- Navigation Links -->
                <NavLink v-if="isAuth" :href="route('config.index')" :active="route().current('config.index')">
                  Configs
                </NavLink>
        <!-- Responsive Navigation Menu -->
            <ResponsiveNavLink v-if="isAuth" :href="route('config.index')" :active="route().current('config.index')">
              Configs
            </ResponsiveNavLink>
```
