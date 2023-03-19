<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $users = User::all()->map(function ($user) {
      $roles = $user->roles()->get();
      $user['roles'] = $roles;
      return $user;
    });
    return Inertia::render(
      'User/Index',
      [
        'users' => $users->toArray(),
      ]
    );
  }

  /**
   * Impersonate
   */
  public function start(User $user)
  {
    $originalId = auth()->user()->id;
    session()->put('impersonate', $originalId);
    auth()->loginUsingId($user->id);
    //dd($user->id,session()->get('impersonate'),auth()->user());
    return redirect()->route('dashboard');
  }
  public function stop()
  {
    $originalId = session()->get('impersonate');
    auth()->loginUsingId($originalId);
    session()->forget('impersonate');
    return redirect(route('user.index'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    $user = User::findOrFail($request->id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {
    $request->validate([
      'password' => ['required', 'current-password'],
    ]);
    $user = User::findOrFail($request->id);
    $user->delete();
  }
}
