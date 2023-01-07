<x-app-layout>
  <x-slot name="header">
    {{ __('Manage korisnika!')}}
  </x-slot>

  <x-bg-div max="xl">
    <x-text-div density="high" class="text-xl">{{ __('Manage') .' '. $user->name }}</x-text-div>
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
      @csrf
      @method('PUT')

      <!-- role -->
      @foreach ($roles as $role)
      <div class="mt-4">
        <x-input-label for="{{ $role->name }}" :value="$role->name" />
        <input id="{{ $role->name }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $user->hasAnyRole($role->name)?'checked':'' }}>
      </div>
      @endforeach

      <div class="flex items-center justify-end mt-4">
        <x-primary-button class="ml-4">
          {{ __('Spremi') }}
        </x-primary-button>
      </div>
    </form>
  </x-bg-div>
</x-app-layout>