<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
      {{ __('Portfolio Information') }}
    </h2>
    @if(count($coins) > 0)
    @foreach($coins as $coin)
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $coin['name'] }} ({{ $coin['all'].' '.$coin['coin'] }} - {{ round($coin['all'] * $coin['price'],2) }}€)</p>
    @endforeach
    @else
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('No coin found') }}</p>
    @endif
  </header>
</section>