<x-app-layout>
  <x-slot name="header">
    {{ __('Manage Users') }}
  </x-slot>

  <x-bg-div max="xxl">
    <table class="table-auto w-full text-gray-900 dark:text-white">
      <thead>
        <tr>
          <th>{{ __('Name') }}</th>
          <th>{{ __('Email') }}</th>
          <th>{{ __('Roles') }}</th>
          <th>{{ __('Actions') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
        <tr>
          <th>{{$user->name}}</th>
          <td>{{$user->email}}</td>
          <td>{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
          <td>
            <a class="float-left" href="{{ route('admin.users.edit', $user->id) }}" title="{{ __('Izmjeni') }}">
              <x-icon-pen width="18" height="18" fill="currentColor" />
            </a>
            <a class="float-right" href="{{ route('admin.users.destroy', $user) }}" onclick="event.preventDefault();
document.getElementById('delete-form-{{ $user->id }}').submit();" title="Izbriši">
              <x-icon-trash width="18" height="18" fill="currentColor" />
            </a>
            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: none;">
              @csrf
              @method('DELETE')
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $users->links() }}
  </x-bg-div>
</x-app-layout>