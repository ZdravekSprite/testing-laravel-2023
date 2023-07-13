<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
      {{ __('Portfolio Information') }}
    </h2>
    @if(count($coins) > 0)
    <table class="table-auto w-full">
      <thead>
        <tr>
          <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Name') }}</th>
          <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('All') }}</th>
          <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Price') }}</th>
          <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Free') }}</th>
          <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Locked') }}</th>
          <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Freeze') }}</th>
          <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Withdrawing') }}</th>
          <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Ipoing') }}</th>
          <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Ipoable') }}</th>
          <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Storage') }}</th>
          <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Lending') }}</th>
          <th class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Earn') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach($coins as $coin)
        <tr>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $coin['name'] }}</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $coin['all'].' '.$coin['coin'] }}</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ round($coin['all'] * $coin['price'],2) }}€</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $coin['free'] }}</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $coin['locked'] }}</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $coin['freeze'] }}</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $coin['withdrawing'] }}</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $coin['ipoing'] }}</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $coin['ipoable'] }}</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $coin['storage'] }}</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $coin['lending'] }}</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $coin['earn'] }}</td>
        </tr>
        @endforeach
        <tr>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Sum') }}</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ round($sum,2) }}€</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ round($sum * 7.5345,2) }}kn</td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
          <td class="mt-1 text-sm text-gray-600 dark:text-gray-400"></td>
        </tr>
      </tbody>
    </table>
    @else
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('No coin found') }}</p>
    @endif
  </header>
</section>