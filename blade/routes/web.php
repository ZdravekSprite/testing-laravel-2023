<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\Admin\ImpersonateController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  //return view('welcome');
  return view('root');
})->name('home');

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::resource('holidays', HolidayController::class);

Route::get('login/{provider}', function ($provider) {
  return Socialite::driver($provider)->redirect();
})->name('{provider}Login');
Route::get('login/{provider}/callback', function ($provider) {
  $social_user = Socialite::driver($provider)->user();
  $user = User::firstOrCreate([
    'email' => $social_user->getEmail(),
  ]);
  if (!$user->name) {
    $user->name = $social_user->getName();
  }
  if (!$user[$provider . "_id"]) {
    $user[$provider . "_id"] = $social_user->getId();
  }
  if ($social_user->getAvatar()) {
    if ($provider == 'facebook') {
      $url = $social_user->getAvatar() . '&access_token=' . $social_user->token;
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

      $res = curl_exec($ch);
      $redirectedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
      $avatar = $redirectedUrl;
    } else {
      $avatar = $social_user->getAvatar();
    }
    if (!$user[$provider . "_avatar"]) {
      $user[$provider . "_avatar"] = $avatar;
    }
    if (!$user["avatar"]) {
      $user["avatar"] = $avatar;
    }
  }
  if (!$user->roles->pluck('name')->contains('socialuser')) {
    $socialUserRole = Role::where('name', 'socialuser')->first();
    $user->roles()->attach($socialUserRole);
  }
  $user->save();
  Auth::Login($user, true);
  return redirect(route('dashboard'));
})->name('{provider}Callback');
/*
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('{provider}Login');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('{provider}Callback');
*/

Route::get('admin/impersonate/stop', [ImpersonateController::class, 'stop'])->name('admin.impersonate.stop');
Route::prefix('admin')->middleware(['auth', 'auth.admin'])->name('admin.')->group(function () {
  Route::resource('/users', UserController::class, ['except' => ['show', 'create', 'store']]);
  Route::get('/impersonate/{id}', [ImpersonateController::class, 'start'])->name('impersonate.start');
});
