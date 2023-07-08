<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('coins', function (Blueprint $table) {
      $table->id();
      $table->string('coin');
      $table->boolean('depositAllEnable')->nullable();
      $table->boolean('withdrawAllEnable')->nullable();
      $table->string('name')->nullable();
      $table->integer('free')->nullable();
      $table->integer('locked')->nullable();
      $table->integer('freeze')->nullable();
      $table->integer('withdrawing')->nullable();
      $table->integer('ipoing')->nullable();
      $table->integer('ipoable')->nullable();
      $table->integer('storage')->nullable();
      $table->boolean('isLegalMoney')->nullable();
      $table->boolean('trading')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('coins');
  }
};
