<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Role::truncate();
    Role::create(['name' => 'superadmin', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/5/55/User-admin-gear.svg']);
    Role::create(['name' => 'admin', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_1.svg']);
    Role::create(['name' => 'user', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Blank_user.svg']);
    Role::create(['name' => 'socialuser', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_2.svg']);
    Role::create(['name' => 'blockeduser', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/0/0a/Gnome-stock_person.svg']);
    DB::table('role_user')->truncate();
    $superadminRole = Role::where('name', 'superadmin')->first();
    $adminRole = Role::where('name', 'admin')->first();
    $super_admin = User::create([
      'name' => env('SUPER_ADMIN_NAME', 'Super Admin'),
      'email' =>  env('SUPER_ADMIN_EMAIL', 'super@admin.com'),
      'password' => Hash::make(env('SUPER_ADMIN_PASS', 'password')),
    ]);
    $super_admin->roles()->attach($superadminRole);
    $super_admin->roles()->attach($adminRole);
  }
}
