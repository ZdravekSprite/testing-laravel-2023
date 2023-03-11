@props(['max' => 'xl'])

@php
switch ($max) {
  case 'xxl':
    $maxClasses = 'max-w-xxl';
    break;
  case 'xl':
    default:
    $maxClasses = 'max-w-xl';
    break;
}
@endphp

<div {!! $attributes->merge(['class' => 'p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden']) !!}>
  <div class="{{ $maxClasses }}">
    {{ $slot }}
  </div>
</div>
