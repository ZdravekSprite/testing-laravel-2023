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
    <img src="{{ $user->avatar }}" class="user-image rounded-full w-24" alt="User Image" title="{{ $user->avatar }}">
  </div>
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
</section>