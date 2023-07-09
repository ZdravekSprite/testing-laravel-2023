<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
      {{ __('Binance Information') }}
    </h2>
  </header>

  <form method="post" action="{{ route('binance.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')

    <div>
      <x-input-label for="api_key" :value="__('API_KEY')" />
      <x-text-input id="api_key" name="api_key" type="text" class="mt-1 block w-full" :value="old('api_key', $binance->api_key)" required autofocus autocomplete="api_key" />
      <x-input-error class="mt-2" :messages="$errors->get('api_key')" />
    </div>

    <div>
      <x-input-label for="api_secret" :value="__('API_SECRET')" />
      <x-text-input id="api_secret" name="api_secret" type="text" class="mt-1 block w-full" :value="old('api_secret', $binance->api_secret)" required autocomplete="api_secret" />
      <x-input-error class="mt-2" :messages="$errors->get('api_secret')" />
    </div>

    <div>
      <x-input-label for="timeout" :value="__('Timeout')" />
      <x-text-input id="timeout" name="timeout" type="number" class="mt-1 block w-full" :value="old('timeout', $binance->timeout)" required autocomplete="timeout" />
      <x-input-error class="mt-2" :messages="$errors->get('timeout')" />
    </div>

    <div class="flex items-center gap-4">
      <x-primary-button>{{ __('Save') }}</x-primary-button>

      @if (session('status') === 'binance-updated')
      <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
      @endif
    </div>
  </form>
</section>