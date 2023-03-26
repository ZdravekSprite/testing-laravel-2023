<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    if (!Warehouse::where('name', 'unknown')->first()) {
      Warehouse::create([
        'name' => 'unknown',
        'description' => 'Unknown type'
      ]);
    }
  }
}
