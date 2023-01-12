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
  @include('auth.partials.login-with')
</x-guest-layout>