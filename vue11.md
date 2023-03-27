# Import

```bash
php artisan make:controller ImportController --invokable
```

- vue\app\Http\Requests\ImportRequest.php

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
   */
  public function rules(): array
  {
    return [
      //
    ];
  }
}
```

- vue\resources\js\Components\ImportForm.vue

```ts
<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  model: {
    type: String,
    default: "",
  },
  fileName: {
    type: String,
    default: 'import.csv',
  },
});

const confirmingImport = ref(false);
const fileNameInput = ref(props.fileName);

const form = useForm({
  fileName: props.fileName,
  model: props.model,
});

const confirmImport = () => {
  confirmingImport.value = true;
};

const importData = () => {
  form.post(route('import'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingImport.value = false;
  form.reset();
};
</script>

<template>
  <div>
    <SecondaryButton @click="confirmImport">
      Import
    </SecondaryButton>

    <Modal :show="confirmingImport" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Import?
        </h2>
        <div class="mt-6">
          <InputLabel for="fileName" value="File Name" class="sr-only" />
          <TextInput id="fileName" ref="fileNameInput" v-model="form.fileName" type="text" class="mt-1 block w-3/4"
            placeholder="File Name" @keyup.enter="importData" />
          <InputError :message="form.errors.fileName" class="mt-2" />
        </div>
        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
          <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="importData">
            Import
          </PrimaryButton>
        </div>
      </div>
    </Modal>
  </div>
</template>
```

- vue\resources\js\Pages\Role\Index.vue

```ts
import ImportForm from '@/Components/ImportForm.vue';
        <ImportForm class="p-1" />
```

- vue\app\Http\Controllers\ImportController.php

```php
use App\Models\Device;
use App\Models\Type;
use App\Models\Warehouse;
use App\Models\Owner;
  public function __invoke(ImportRequest $request)
  {
    set_time_limit(0);
    $fileName = $request->fileName;
    $csvData = fopen(public_path('temp/' . $fileName), 'r');
    $columns = [];
    $deviceRow = false;
    while (($data = fgetcsv($csvData, 555, ',')) !== false) {
      if ($deviceRow) {
        $this->importDevice((object) array_combine($columns, $data));
        $arrayData[] = array_combine($columns, $data);
      } else {
        $columns = $data;
        $deviceRow = true;
      }
    }
  }
  public function importDevice($device): void
  {
    if (!Device::where('imei', $device->imei)->first()) {
      $type = trim($device->type) != '' ? Type::where('name',$device->type)->first() : Type::where('name','unknown')->first();
      if ($type) {
        $type_id = $type->id;
      } else {
        $type_id = Type::create([
          'name' => $device->type,
        ])->id;
      }
      $warehouse = !in_array(trim($device->warehouse), ['', 0, '0'])  ? Warehouse::where('name',$device->warehouse)->first() : Warehouse::where('name','unknown')->first();
      if ($warehouse) {
        $warehouse_id = $warehouse->id;
      } else {
        $warehouse_id = Warehouse::create([
          'name' => $device->warehouse,
        ])->id;
      }
      $owner = trim($device->owner) != '' ? Owner::where('name',$device->owner)->first() : Owner::where('name','unknown')->first();
      if ($owner) {
        $owner_id = $owner->id;
      } else {
        $owner_id = Owner::create([
          'name' => $device->owner,
        ])->id;
      }
      Device::create([
        'imei' => $device->imei,
        'gsm' => $device->gsm,
        'type_id' => $type_id,
        'warehouse_id' => $warehouse_id,
        'owner_id' => $owner_id,
        'description' => $device->description,
      ]);
    }
  }
```

- vue\routes\web.php

```php
use App\Http\Controllers\ImportController;
Route::post('/import', ImportController::class)->name('import');
```
