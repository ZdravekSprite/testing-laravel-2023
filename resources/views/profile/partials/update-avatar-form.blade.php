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

  <!-- Social Icons -->
  @if ($user->google_id)
  <div>
    <x-p value="{{ $user->google_id }}" />
    <img src="{{ $user->google_avatar }}" class="user-image rounded-full w-24" alt="User Image" title="{{ $user->google_avatar }}">
  </div>
  @endif
  @if ($user->facebook_id)
  <div>
    <x-p value="{{ $user->facebook_id }}" />
    <img src="{{ $user->facebook_avatar }}" class="user-image rounded-full w-24" alt="User Image" title="{{ $user->facebook_avatar }}">
  </div>
  @endif
  @if ($user->twitter_id)
  <div>
    <x-p value="{{ $user->twitter_id }}" />
    <img src="{{ $user->twitter_avatar }}" class="user-image rounded-full w-24" alt="User Image" title="{{ $user->twitter_avatar }}">
  </div>
  @endif
  @if ($user->github_id)
  <div>
    <x-p value="{{ $user->github_id }}" />
    <img src="{{ $user->github_avatar }}" class="user-image rounded-full w-24" alt="User Image" title="{{ $user->github_avatar }}">
  </div>
  @endif

  <!-- Role Icons -->
  @hasrole('superadmin')
  <div>
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/55/User-admin-gear.svg" class="user-image rounded-full w-24" alt="superadmin">
  </div>
  @endhasrole
  @hasrole('admin')
  <div>
    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_1.svg" class="user-image rounded-full w-24" alt="admin">
  </div>
  @endhasrole
  @hasrole('socialuser')
  <div>
    <img src="https://upload.wikimedia.org/wikipedia/commons/1/1d/Gnome-system-users.svg" class="user-image rounded-full w-24" alt="socialuser">
  </div>
  @endhasrole
  @hasrole('blockeduser')
  <div>
    <img src="https://upload.wikimedia.org/wikipedia/commons/0/0a/Gnome-stock_person.svg" class="user-image rounded-full w-24" alt="blockeduser">
  </div>
  @endhasrole
  <div>
    <img src="https://upload.wikimedia.org/wikipedia/commons/1/12/User_icon_2.svg" class="user-image rounded-full w-24" alt="user">
  </div>
</section>