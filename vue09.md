# Search

- vue\resources\js\Pages\Role\Index.vue

```ts
<script setup>
import TextInput from '@/Components/TextInput.vue';
import {ref, watch} from "vue"
const props = defineProps({
  roles: Array,
});

const roles = ref(props.roles)
const search = ref("")

watch(search, () => {
  roles.value = props.roles.filter(r => r.name.toString().includes(search.value))
})
</script>
<template>
        <TextInput id="searchName" v-model.trim="search" type="text" class="block w-3/4" placeholder="Search name..." />
</template>
```
