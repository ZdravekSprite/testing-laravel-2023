@props(['value'])

<p {!! $attributes->merge(['class' => 'mt-1 text-sm text-gray-600 dark:text-gray-500']) !!}>
  {{ $value ?? $slot }}
</p>
