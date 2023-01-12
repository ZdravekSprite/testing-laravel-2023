<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-400">
    {{ __('Role!')}}
    </h2>
  </header>

  <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
    @csrf
    @method('PUT')

    <!-- role -->
    @foreach ($roles as $role)
    <div class="m-4">
      <x-label-checkbox :id="$role->name" name="roles[]" :value="$role->id" :checked="$user->hasAnyRole($role->name)">
        {{ $role->name }}
      </x-label-checkbox>
    </div>
    @endforeach

    <div class="flex items-center gap-4">
      <x-primary-button>{{ __('Save') }}</x-primary-button>

      @if (session('status') === 'roles-updated')
      <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
      @endif
    </div>
  </form>
</section>