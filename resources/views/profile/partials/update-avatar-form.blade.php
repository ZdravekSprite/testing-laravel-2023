<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-400">
      {{ __('Social Information') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-500">
      {{ __("Update your account's social information.") }}
    </p>
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