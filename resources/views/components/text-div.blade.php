@props(['value', 'density' => 'normal'])

@php
$textClasses = 'text-sm mt-2
switch ($density) {
  case 'high':
    $textClasses .= ' text-gray-900 dark:text-white';
    break;
  case 'normal':
    $textClasses .= ' text-gray-600 dark:text-gray-300';
    break;
  case 'low':
    default:
    $textClasses .= ' text-gray-500';
    break;
}
@endphp

<div {!! $attributes->merge(['class' => $textClasses]) !!}>
  {{ $value ?? $slot }}
</div>
