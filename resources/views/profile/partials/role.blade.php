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
      <x-label-checkbox :id="$role->name" name="roles[]" :checked="$user->hasAnyRole($role->name)">
        {{ $role->name }}
      </x-label-checkbox>
    </div>
    @endforeach

    <div class="flex items-center gap-4">
      <x-primary-button>{{ __('Save') }}</x-primary-button>
    </div>
  </form>
</section>