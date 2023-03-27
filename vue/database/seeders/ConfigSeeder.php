<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    if (!Config::where('name', 'unknown')->first()) {
      Config::create([
        'name' => 'unknown',
        'description' => 'Unknown configuration'
      ]);
    }
  }
}
