# Device

```bash
php artisan make:model Device -a
```

- vue\database\migrations\2023_03_26_103026_create_devices_table.php

```php
    Schema::create('devices', function (Blueprint $table) {
      $table->id();
      $table->string('imei')->unique();
      $table->string('gsm')->nullable();
      $table->foreignId('type_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->foreignId('warehouse_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->foreignId('owner_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->string('description')->nullable();
      $table->timestamps();
    });
```

- vue\app\Models\Device.php

```php
use Illuminate\Database\Eloquent\Relations\BelongsTo;
  protected $hidden = [
    'type_id',
    'warehouse_id',
    'owner_id',
    'created_at',
    'updated_at',
  ];
  protected $fillable = [
    'imei',
    'gsm',
    'type_id',
    'warehouse_id',
    'owner_id',
    'description',
  ];
  /**
   * Accessors.
   */
  protected $appends = ['type', 'warehouse', 'owner'];

  public function getTypeAttribute()
  {
    $type = Type::where('id',$this->type_id)->first();
    return $type->name;
  }
  public function getWarehouseAttribute()
  {
    $type = Warehouse::where('id',$this->warehouse_id)->first();
    return $type->name;
  }
  public function getOwnerAttribute()
  {
    $type = Owner::where('id',$this->owner_id)->first();
    return $type->name;
  }
  public function type(): BelongsTo
  {
    return $this->belongsTo(Type::class);
  }
```

```bash
php artisan migrate
```

- vue\resources\js\Pages\Device.vue

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
  devices: Array,
  types: Array,
  warehouses: Array,
  owners: Array,
});

const devices = ref(props.devices)
const search = ref("")

watch(search, () => {
  devices.value = props.devices.filter(d => d.imei.toString().includes(search.value))
})
</script>

<template>
  <Head title="Devices" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <h2 class="p-2 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Devices</h2>
        <NewForm :storeRoute="('device.store')"
          :labels="[['imei'], ['gsm'], ['type', props.types], ['warehouse', props.warehouses], ['owner', props.owners], ['description']]"
          class="p-1" />
        <ImportForm fileName="devices.csv" model="Device" class="p-1" />
        <ExportForm :elements="devices" fileName="devices.csv" class="p-1" />
        <TextInput id="searchName" v-model.trim="search" type="text" class="block w-3/4" placeholder="Search imei..." />
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <IndexList :elements="devices" :labels="['imei', 'gsm', 'type', 'warehouse', 'owner', 'description']"
            actionRoute="device." :actions="['edit', 'delete']" />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
```

- vue\app\Http\Requests\StoreDeviceRequest.php

```php
  public function authorize(): bool
  {
    return $this->user()->hasAnyRoles(['superadmin','admin','user']);
  }
  public function rules(): array
  {
    return [
      'imei' => ['string', 'max:255', 'unique:devices'],
      'gsm' => ['nullable', 'string', 'max:255'],
      'description' => ['nullable', 'string', 'max:255'],
    ];
  }
```

- vue\app\Http\Requests\UpdateDeviceRequest.php

```php
use App\Models\Device;
use Illuminate\Validation\Rule;
  public function authorize(): bool
  {
    return Device::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }
  public function rules(): array
  {
    return [
      'imei' => ['string', 'max:255', Rule::unique(Device::class)->ignore($this->id)],
      'gsm' => ['nullable', 'string', 'max:255'],
      'description' => ['nullable', 'string', 'max:255'],
    ];
  }
```

- vue\app\Http\Requests\DestroyDeviceRequest.php

```php
<?php

namespace App\Http\Requests;

use App\Models\Device;
use Illuminate\Foundation\Http\FormRequest;

class DestroyDeviceRequest extends FormRequest
{
  public function authorize(): bool
  {
    return Device::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }
  public function rules(): array
  {
    return [
      //
    ];
  }
}
```

- vue\app\Http\Controllers\DeviceController.php

```php
use App\Http\Requests\DestroyDeviceRequest;
use Inertia\Inertia;
  public function index()
  {
    return Inertia::render(
      'Device',
      [
        'devices' => Device::all(),
        'types' => Type::all(),
        'warehouses' => Warehouse::all(),
        'owners' => Owner::all(),
      ]
    );
  }
  public function store(StoreDeviceRequest $request)
  {
    $device = new Device();
    $device->imei = $request->imei;
    $device->gsm = $request->gsm;
    $device->type_id = $request->type;
    $device->warehouse_id = $request->warehouse;
    $device->owner_id = $request->owner;
    $device->description = $request->description;
    $device->save();
  }
  public function update(UpdateDeviceRequest $request, Device $device)
  {
    $device->imei = $request->imei;
    $device->gsm = $request->gsm;
    $device->type_id = $request->type;
    $device->warehouse_id = $request->warehouse;
    $device->owner_id = $request->owner;
    $device->description = $request->description;
    $device->save();
  }
  public function destroy(DestroyDeviceRequest $request, Device $device)
  {
    $device->delete();
  }
```

- vue\routes\web.php

```php
use App\Http\Controllers\DeviceController;
  Route::get('/devices', [DeviceController::class, 'index'])->name('device.index');
  Route::post('/device', [DeviceController::class, 'store'])->name('device.store');
  Route::patch('/device/{device}', [DeviceController::class, 'update'])->name('device.update');
  Route::delete('/device/{device}', [DeviceController::class, 'destroy'])->name('device.destroy');
```

- vue\resources\js\Layouts\AuthenticatedLayout.vue

```ts
              <!-- Navigation Links -->
                <NavLink v-if="isAuth" :href="route('device.index')" :active="route().current('device.index')">
                  Devices
                </NavLink>
        <!-- Responsive Navigation Menu -->
            <ResponsiveNavLink v-if="isAuth" :href="route('device.index')" :active="route().current('device.index')">
              Devices
            </ResponsiveNavLink>
```
