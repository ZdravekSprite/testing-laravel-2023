# Export

```bash
php artisan make:controller ExportController --invokable
```

- vue\app\Http\Requests\ExportRequest.php

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
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

- vue\app\Http\Controllers\ExportController.php

```php
use App\Http\Requests\ExportRequest;
  public function __invoke(ExportRequest $request)
  {
    dd($request->arrayData);
  }
```

- vue\routes\web.php

```php
use App\Http\Controllers\ExportController;
Route::post('/export', ExportController::class)->name('export');
```

- vue\resources\js\Components\ExportForm.vue

```ts
<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  elements: Array,
});

const confirmingExport = ref(false);

const form = useForm({
  arrayData: props.elements,
});

const confirmExport = () => {
  confirmingExport.value = true;
};

const exportData = () => {
  form.post(route('export'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingExport.value = false;
  form.reset();
};
</script>

<template>
  <div>
    <SecondaryButton @click="confirmExport">
      Export
    </SecondaryButton>

    <Modal :show="confirmingExport" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Export {{ props.elements.length }} elements?
        </h2>
        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
          <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="exportData">
            Export
          </PrimaryButton>
        </div>
      </div>
    </Modal>
  </div>
</template>
```

- vue\resources\js\Pages\Role\Index.vue

```ts
import ExportForm from '@/Components/ExportForm.vue';
        <ExportForm :elements="types" class="p-1" />
```
