<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-400">
      {{ __('Social Information') }}
    </h2>

    <x-p>
      {{ __("Update your account's social information.") }}
    </x-p>
  </header>

  <div>
    <img src="{{ $user->icon() }}" class="user-image rounded-full w-24" alt="User Image" title="{{ $user->icon() }}">
  </div>
  <div class="flex justify-between items-center">
    <hr class="w-full">
    <span class="p-2 text-gray-400 m-1">OR</span>
    <hr class="w-full">
  </div>

  <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
    @csrf
    @method('PUT')

    <div class="flex m-4 space-x-4">
    <!-- Social Icons -->
    @if ($user->google_id)
    <x-label-radio :id="$user->google_id" name="avatars[]" :value="$user->google_avatar">
      <img src="{{ $user->google_avatar }}" class="rounded-full w-24" alt="{{ $user->google_id }}" title="{{ $user->google_avatar }}">
    </x-label-radio>
    @endif
    @if ($user->facebook_id)
    <x-label-radio :id="$user->facebook_id" name="avatars[]" :value="$user->facebook_avatar">
      <img src="{{ $user->facebook_avatar }}" class="rounded-full w-24" alt="{{ $user->facebook_id }}" title="{{ $user->facebook_avatar }}">
    </x-label-radio>
    @endif
    @if ($user->twitter_id)
    <x-label-radio :id="$user->twitter_id" name="avatars[]" :value="$user->twitter_avatar">
      <img src="{{ $user->twitter_avatar }}" class="rounded-full w-24" alt="{{ $user->twitter_id }}" title="{{ $user->twitter_avatar }}">
    </x-label-radio>
    @endif
    @if ($user->github_id)
    <x-label-radio :id="$user->github_id" name="avatars[]" :value="$user->github_avatar">
      <img src="{{ $user->github_avatar }}" class="rounded-full w-24" alt="{{ $user->github_id }}" title="{{ $user->github_avatar }}">
    </x-label-radio>
    @endif
    </div>

    <div class="flex m-4 space-x-4">
    <!-- Role Icons -->
    @hasrole('superadmin')
    <x-label-radio id="superadmin-avatar" name="avatars[]" value="https://upload.wikimedia.org/wikipedia/commons/5/55/User-admin-gear.svg">
      <img src="https://upload.wikimedia.org/wikipedia/commons/5/55/User-admin-gear.svg" class="rounded-full w-24" alt="superadmin">
    </x-label-radio>
    @endhasrole
    @hasrole('admin')
    <x-label-radio id="admin-avatar" name="avatars[]" value="https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_1.svg">
      <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_1.svg" class="rounded-full w-24" alt="admin">
    </x-label-radio>
    @endhasrole
    @hasrole('socialuser')
    <x-label-radio id="socialuser-avatar" name="avatars[]" value="https://upload.wikimedia.org/wikipedia/commons/1/1d/Gnome-system-users.svg">
      <img src="https://upload.wikimedia.org/wikipedia/commons/1/1d/Gnome-system-users.svg" class="rounded-full w-24" alt="socialuser">
    </x-label-radio>
    @endhasrole
    @hasrole('blockeduser')
    <x-label-radio id="blockeduser-avatar" name="avatars[]" value="https://upload.wikimedia.org/wikipedia/commons/0/0a/Gnome-stock_person.svg">
      <img src="https://upload.wikimedia.org/wikipedia/commons/0/0a/Gnome-stock_person.svg" class="rounded-full w-24" alt="blockeduser">
    </x-label-radio>
    @endhasrole
    <x-label-radio id="user-avatar" name="avatars[]" value="https://upload.wikimedia.org/wikipedia/commons/1/12/User_icon_2.svg">
      <img src="https://upload.wikimedia.org/wikipedia/commons/1/12/User_icon_2.svg" class="rounded-full w-24" alt="user">
    </x-label-radio>
    </div>

    <div class="flex items-center gap-4">
      <x-primary-button>{{ __('Save') }}</x-primary-button>

      @if (session('status') === 'avatar-updated')
      <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
      @endif
    </div>
  </form>
</section>