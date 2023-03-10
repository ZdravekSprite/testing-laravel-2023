<x-app-layout>
  <x-slot name="header">
    {{ __('Praznici') }}
  </x-slot>

  <x-bg-div max="xxl">
    @if(count($holidays) > 0)
      @foreach($holidays as $day)
        @if($day->date->format('Y.m.d') < date('Y.m.d'))
          <x-text-div density="low">{{$day->date->format('d.m.Y')}} {{$day->name}}</x-text-div>
        @elseif($day->date->format('Y.m.d') === date('Y.m.d'))
          <x-text-div density="high">{{$day->date->format('d.m.Y')}} {{$day->name}}</x-text-div>
        @else
          <x-text-div>{{$day->date->format('d.m.Y')}} {{$day->name}}</x-text-div>
        @endif
      @endforeach
    @else
      <x-text-div>No holidays found</x-text-div>
    @endif
  </x-bg-div>
</x-app-layout>