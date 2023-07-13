<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Coin') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
          @include('coin.partials.coin-information')
        </div>
      </div>
      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
          @if(count($coins) > 0)
          <table class="table-auto w-full">
            <thead>
              <tr>
                <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Name') }}</th>
                <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Trading') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach($coins as $coin)
              <tr>
                <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{$coin->name}}</td>
                <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{$coin->trading}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
          <p> No coins found</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>