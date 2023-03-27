<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
});

Route::get('/dashboard', function () {
  return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  Route::get('/types', [TypeController::class, 'index'])->name('type.index');
  Route::post('/type', [TypeController::class, 'store'])->name('type.store');
  Route::patch('/type/{type}', [TypeController::class, 'update'])->name('type.update');
  Route::delete('/type/{type}', [TypeController::class, 'destroy'])->name('type.destroy');
  Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouse.index');
  Route::post('/warehouse', [WarehouseController::class, 'store'])->name('warehouse.store');
  Route::patch('/warehouse/{warehouse}', [WarehouseController::class, 'update'])->name('warehouse.update');
  Route::delete('/warehouse/{warehouse}', [WarehouseController::class, 'destroy'])->name('warehouse.destroy');
  Route::get('/owners', [OwnerController::class, 'index'])->name('owner.index');
  Route::post('/owner', [OwnerController::class, 'store'])->name('owner.store');
  Route::patch('/owner/{owner}', [OwnerController::class, 'update'])->name('owner.update');
  Route::delete('/owner/{owner}', [OwnerController::class, 'destroy'])->name('owner.destroy');
  Route::get('/devices', [DeviceController::class, 'index'])->name('device.index');
  Route::post('/device', [DeviceController::class, 'store'])->name('device.store');
  Route::patch('/device/{device}', [DeviceController::class, 'update'])->name('device.update');
  Route::delete('/device/{device}', [DeviceController::class, 'destroy'])->name('device.destroy');
  Route::get('/configs', [ConfigController::class, 'index'])->name('config.index');
  Route::post('/config', [ConfigController::class, 'store'])->name('config.store');
  Route::patch('/config/{config}', [ConfigController::class, 'update'])->name('config.update');
  Route::delete('/config/{config}', [ConfigController::class, 'destroy'])->name('config.destroy');
});

Route::get('/user/stop', [UserController::class, 'stop'])->name('user.stop');
Route::post('/export', ExportController::class)->name('export');
Route::post('/import', ImportController::class)->name('import');
Route::middleware('auth.admin')->group(function () {
  Route::get('/roles', [RoleController::class, 'index'])->name('role.index');
  Route::post('/role', [RoleController::class, 'store'])->name('role.store');
  Route::patch('/role/{role}', [RoleController::class, 'update'])->name('role.update');
  Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('role.destroy');
  Route::get('/users', [UserController::class, 'index'])->name('user.index');
  Route::get('/user/{user}', [UserController::class, 'start'])->name('user.start');
  Route::patch('/user', [UserController::class, 'update'])->name('user.update');
  Route::delete('/user', [UserController::class, 'destroy'])->name('user.destroy');
});

require __DIR__ . '/auth.php';
