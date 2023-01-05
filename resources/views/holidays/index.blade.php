<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Praznici') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xxl">
          @if(count($holidays) > 0)
          @foreach($holidays as $day)
          <div class="text-sm mt-2 text-gray-800 dark:text-gray-400">
            {{$day->date->format('d.m.Y')}} {{$day->name}} 
          </div>
          @endforeach
          @else
          <p> No holidays found</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>