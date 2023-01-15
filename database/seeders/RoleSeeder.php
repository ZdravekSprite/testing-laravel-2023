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
    //https://upload.wikimedia.org/wikipedia/commons/5/55/User-admin-gear.svg
    Role::create(['name' => 'admin']);
    //https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_1.svg
    Role::create(['name' => 'user']);
    //https://upload.wikimedia.org/wikipedia/commons/a/aa/Blank_user.svg
    Role::create(['name' => 'socialuser']);
    //https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_2.svg
    Role::create(['name' => 'blockeduser']);
    //https://upload.wikimedia.org/wikipedia/commons/0/0a/Gnome-stock_person.svg
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
