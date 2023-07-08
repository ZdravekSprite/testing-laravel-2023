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
    Schema::create('networks', function (Blueprint $table) {
      $table->id();
      $table->foreignId('coin_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->string('network');
      $table->string('coin')->nullable();
      $table->string('entityTag')->nullable();
      $table->string('withdrawIntegerMultiple')->nullable();
      $table->boolean('isDefault')->nullable();
      $table->boolean('depositEnable')->nullable();
      $table->boolean('withdrawEnable')->nullable();
      $table->string('depositDesc')->nullable();
      $table->string('withdrawDesc')->nullable();
      $table->string('specialTips')->nullable();
      $table->string('specialWithdrawTips')->nullable();
      $table->string('name')->nullable();
      $table->boolean('resetAddressStatus')->nullable();
      $table->string('addressRegex')->nullable();
      $table->string('addressRule')->nullable();
      $table->string('memoRegex')->nullable();
      $table->string('withdrawFee')->nullable();
      $table->string('withdrawMin')->nullable();
      $table->string('withdrawMax')->nullable();
      $table->integer('minConfirm')->nullable();
      $table->integer('unLockConfirm')->nullable();
      $table->boolean('sameAddress')->nullable();
      $table->integer('estimatedArrivalTime')->nullable();
      $table->boolean('busy')->nullable();
      $table->string('country')->nullable();
      $table->string('contractAddressUrl')->nullable();
      $table->string('contractAddress')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('networks');
  }
};
