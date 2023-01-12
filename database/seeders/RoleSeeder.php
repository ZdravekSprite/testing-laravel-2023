<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('role_user')->truncate();
    Role::truncate();
    Role::create(['name' => 'superadmin', 'description' => 'Super Admin']);
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'user']);
    Role::create(['name' => 'socialuser']);
    Role::create(['name' => 'blockeduser']);
    $superadminRole = Role::where('name', 'superadmin')->first();
    $adminRole = Role::where('name', 'admin')->first();
    $super_admin = User::where('email', env('SUPER_ADMIN_EMAIL', 'super@admin.com'))->first();
    if (!$super_admin) {
      $super_admin = User::create([
        'name' => env('SUPER_ADMIN_NAME', 'Super Admin'),
        'email' =>  env('SUPER_ADMIN_EMAIL', 'super@admin.com'),
        'password' => Hash::make(env('SUPER_ADMIN_PASS', 'password')),
        'avatar' => 'https://upload.wikimedia.org/wikipedia/commons/5/55/User-admin-gear.svg'
      ]);
    }
    $super_admin->roles()->attach($superadminRole);
    $super_admin->roles()->attach($adminRole);
  }
}
