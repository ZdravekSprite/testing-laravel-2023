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
    Schema::create('earns', function (Blueprint $table) {
      $table->id();
      $table->string('earn');
      $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->integer('positionId');
      $table->string('productId');
      $table->string('asset');
      $table->string('amount');
      $table->integer('purchaseTime');
      $table->integer('duration');
      $table->integer('accrualDays');
      $table->string('rewardAsset');
      $table->string('rewardAmt');
      $table->string('nextPay');
      $table->integer('nextPayDate');
      $table->integer('payPeriod');
      $table->string('redeemAmountEarly');
      $table->integer('rewardsEndDate');
      $table->integer('deliverDate');
      $table->integer('redeemPeriod');
      $table->boolean('canRedeemEarly');
      $table->boolean('autoSubscribe');
      $table->string('type');
      $table->string('status');
      $table->boolean('canReStake');
      $table->string('apy');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('earns');
  }
};
