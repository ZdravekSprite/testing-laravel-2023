<x-app-layout>
  <x-slot name="header">
    {{ __('Profile') }}
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <x-bg-div>
        @include('profile.partials.update-profile-information-form')
      </x-bg-div>

      <x-bg-div>
        @include('profile.partials.update-avatar-form')
      </x-bg-div>

      <x-bg-div>
        @include('profile.partials.update-password-form')
      </x-bg-div>

      <x-bg-div>
        @include('profile.partials.delete-user-form')
      </x-bg-div>
    </div>
  </div>
</x-app-layout>