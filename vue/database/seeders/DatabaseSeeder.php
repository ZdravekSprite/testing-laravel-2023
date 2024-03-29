<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call(RoleSeeder::class);
    User::factory()->create([
      'name' => 'Test User',
      'email' => 'test@example.com',
    ]);
    User::factory(5)->create();
    $this->call(TypeSeeder::class);
    $this->call(WarehouseSeeder::class);
    $this->call(OwnerSeeder::class);
    $this->call(ConfigSeeder::class);
  }
}
