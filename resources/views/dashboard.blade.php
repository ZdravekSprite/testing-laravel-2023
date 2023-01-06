<x-app-layout>
  <x-slot name="header">
    {{ __('Dashboard') }}
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <x-bg-div>
        <x-text-div>
          {{ __("You're logged in!") }}
        </x-text-div>
      </x-bg-div>
    </div>
  </div>
</x-app-layout>