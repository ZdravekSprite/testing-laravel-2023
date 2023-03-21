# Components

- [x] list
- [x] action
  - [x] edit
  - [x] delete

- vue\resources\js\Components\EditForm.vue

```ts
<script setup>
import IconPen from '@/Components/IconPen.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
</script>

<template>
  <div>
    <SecondaryButton>
      <IconPen class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </SecondaryButton>
  </div>
</template>
```

- vue\resources\js\Components\DeleteForm.vue

```ts
<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import IconTrash from '@/Components/IconTrash.vue';
</script>

<template>
  <div>
    <DangerButton>
      <IconTrash class="block h-4 w-auto fill-current text-gray-800 dark:text-gray-200" />
    </DangerButton>
  </div>
</template>
```

- vue\resources\js\Components\IndexList.vue

```ts
<script setup>
import DeleteForm from '@/Components/DeleteForm.vue';
import EditForm from '@/Components/EditForm.vue';

defineProps({
  labels: {
    type: Array,
    default: [],
  },
  elements: {
    type: Array,
    default: [],
  },
  actions: {
    type: Array,
    default: [],
  },
});
</script>

<template>
  <table class="table-auto w-full">
    <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
      <tr>
        <th v-if="elements[0].icon" class="w-8"></th>
        <th v-for="l in labels" :key="l.id">{{ l }}</th>
        <th v-if="actions.length" :style="{ width: (actions.length * 60) + 'px' }">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="e in elements" :key="e.id">
        <td v-if="e.icon"><img class="rounded-full shadow-xl" width="20" height="20" :src="e.icon" /></td>
        <td v-for="l in labels" :key="l.id" class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          {{ e[l] }}
        </td>
        <td v-if="actions.length" class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          <EditForm v-if="actions.includes('edit')" class="float-left" :element="e" :labels=labels />
          <DeleteForm v-if="actions.includes('delete')" class="float-right" :element="e" />
        </td>
      </tr>
    </tbody>
  </table>
</template>
```

- vue\resources\js\Pages\Role\Index.vue

```ts
          <IndexList :elements="roles" :labels="['name','description']" :actions="['edit','delete']"/>
```
