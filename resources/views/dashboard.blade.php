<x-app-layout>
  <x-slot name="header">
    {{ __('Dashboard') }}
  </x-slot>

  <x-bg-div>
    <x-text-div>
      {{ __("You're logged in!") }}
    </x-text-div>
  </x-bg-div>
  @hasrole('superadmin')
  <x-bg-div>
    <x-text-div>
      {{ __("You're super admin!") }}
    </x-text-div>
  </x-bg-div>
  @endhasrole
  @hasrole('admin')
  <x-bg-div>
    <x-text-div>
      {{ __("You're admin!") }}
    </x-text-div>
  </x-bg-div>
  @endhasrole
</x-app-layout>