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

  <div class="flex m-4 space-x-4">
  <!-- Social Icons -->
  @if ($user->google_id)
    <img src="{{ $user->google_avatar }}" class="rounded-full w-24" alt="{{ $user->google_id }}" title="{{ $user->google_avatar }}">
  @endif
  @if ($user->facebook_id)
    <img src="{{ $user->facebook_avatar }}" class="rounded-full w-24" alt="{{ $user->facebook_id }}" title="{{ $user->facebook_avatar }}">
  @endif
  @if ($user->twitter_id)
    <img src="{{ $user->twitter_avatar }}" class="rounded-full w-24" alt="{{ $user->twitter_id }}" title="{{ $user->twitter_avatar }}">
  @endif
  @if ($user->github_id)
    <img src="{{ $user->github_avatar }}" class="rounded-full w-24" alt="{{ $user->github_id }}" title="{{ $user->github_avatar }}">
  @endif
  </div>

  <div class="flex m-4 space-x-4">
  <!-- Role Icons -->
  @hasrole('superadmin')
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/55/User-admin-gear.svg" class="rounded-full w-24" alt="superadmin">
  @endhasrole
  @hasrole('admin')
    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_1.svg" class="rounded-full w-24" alt="admin">
  @endhasrole
  @hasrole('socialuser')
    <img src="https://upload.wikimedia.org/wikipedia/commons/1/1d/Gnome-system-users.svg" class="rounded-full w-24" alt="socialuser">
  @endhasrole
  @hasrole('blockeduser')
    <img src="https://upload.wikimedia.org/wikipedia/commons/0/0a/Gnome-stock_person.svg" class="rounded-full w-24" alt="blockeduser">
  @endhasrole
    <img src="https://upload.wikimedia.org/wikipedia/commons/1/12/User_icon_2.svg" class="rounded-full w-24" alt="user">
  </div>
</section>