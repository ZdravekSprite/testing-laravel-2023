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
      <p class="mt-1 text-sm text-gray-900 dark:text-gray-400">
        {{ $user->google_id }}
      </p>
      <p class="mt-1 text-sm text-gray-900 dark:text-gray-400">
        {{ $user->google_avatar }}
      </p>
      <img src="{{ $user->google_avatar }}"  class="user-image" alt="User Image">
    </div>

</section>