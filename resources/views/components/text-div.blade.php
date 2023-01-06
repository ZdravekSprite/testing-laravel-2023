@props(['value', 'density' => 'normal'])

@php
switch ($density) {
  case 'high':
    $textClasses = 'text-sm mt-2 text-gray-900 dark:text-white';
    break;
  case 'normal':
    $textClasses = 'text-sm mt-2 text-gray-600 dark:text-gray-400';
    break;
  case 'low':
    default:
    $textClasses = 'text-sm mt-2 text-gray-500';
    break;
}
@endphp

<div {!! $attributes->merge(['class' => $textClasses]) !!}>
  {{ $value ?? $slot }}
</div>
