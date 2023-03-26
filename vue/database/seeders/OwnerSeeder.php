<?php

namespace Database\Seeders;

use App\Models\Owner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    if (!Owner::where('name', 'unknown')->first()) {
      Owner::create([
        'name' => 'unknown',
        'description' => 'Unknown type'
      ]);
    }
  }
}
