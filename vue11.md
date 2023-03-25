# Import

- vue\resources\js\Components\ImportForm.vue

```ts
<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
</script>

<template>
  <div>
    <SecondaryButton>
      Import
    </SecondaryButton>
  </div>
</template>
```

- vue\resources\js\Pages\Role\Index.vue

```ts
import ImportForm from '@/Components/ImportForm.vue';
        <ImportForm class="p-1" />
```
