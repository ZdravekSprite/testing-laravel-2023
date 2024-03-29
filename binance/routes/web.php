<?php

use App\Http\Controllers\CoinController;
use App\Http\Controllers\BinanceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  Route::get('/binance', [BinanceController::class, 'index'])->name('binance.index');
  Route::patch('/binance', [BinanceController::class, 'update'])->name('binance.update');

  Route::get('/chart', [CoinController::class, 'chart'])->name('chart');
  Route::get('/coins', [CoinController::class, 'index'])->name('coin.index');
});

require __DIR__ . '/auth.php';
