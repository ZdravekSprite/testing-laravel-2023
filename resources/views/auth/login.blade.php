<x-guest-layout>
  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    <div class="m-4">
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="m-4">
      <x-input-label for="password" :value="__('Password')" />
      <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Remember Me -->
    <div class="m-4">
      <x-label-checkbox id="remember_me" name="remember">
        {{ __('Remember me') }}
      </x-label-checkbox>
    </div>

    <div class="flex items-center justify-end m-4">
      @if (Route::has('password.request'))
        <x-underline-link :href="route('password.request')">
          {{ __('Forgot your password?') }}
        </x-underline-link>
      @endif

      <x-primary-button class="ml-4">
        {{ __('Log in') }}
      </x-primary-button>
    </div>
  </form>
  <div class="flex justify-between items-center">
    <hr class="w-full">
    <span class="p-2 text-gray-400 m-1">OR</span>
    <hr class="w-full">
  </div>
  <div class="flex items-center justify-end m-4">
    <x-underline-link href="login/google">
      <strong>{{ __('Login') }}</strong>
      <span>{{ __('with') }}</span>
      <strong>Google</strong>
    </x-underline-link>
    <span class="p-1 m-1"></span>
    <x-underline-link href="login/google">
      <strong>{{ __('Login') }}</strong>
      <span>{{ __('with') }}</span>
      <strong>Google</strong>
    </x-underline-link>
  </div>
</x-guest-layout>