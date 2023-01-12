@props(['value', 'id', 'checked' => false])

<label for={{ $id }} class="inline-flex items-center">
  <input  id={{ $id }} type="checkbox" {{ $checked ? 'checked' : '' }} {{ $value ? 'value='.$value : '' }} {{ $attributes->merge(['class' => 'rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500']) }}>
  <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $slot }}</span>
</label>
