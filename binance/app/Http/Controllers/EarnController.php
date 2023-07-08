<?php

namespace App\Http\Controllers;

use App\Models\Binance;
use App\Models\Coin;
use App\Models\Earn;
use App\Http\Requests\StoreEarnRequest;
use App\Http\Requests\UpdateEarnRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class EarnController extends Controller
{
  public function simpleEarnLockedPosition()
  {
    $user = Auth::user();
    $binance = Binance::whereUserId($user->id)->first();
    if (!$binance) {
      $binance = new Binance();
      $binance->user_id = $user->id;
      $binance->api_key = '';
      $binance->api_secret = '';
      $binance->save();
    }
    if ($binance->api_key != '' && $binance->api_secret != '') {
      $apiKey = $binance->api_key;
      $apiSecret = $binance->api_secret;
      $time = json_decode(Http::get('https://api.binance.com/api/v3/time'));
      $serverTime = $time->serverTime;
      if ($binance->simple_earn_locked_position + $binance->timeout < $serverTime) {
        $binance->simple_earn_locked_position = $serverTime;
        $binance->save();
        $timeStamp = 'timestamp=' . $serverTime;
        $signature = hash_hmac('SHA256', $timeStamp, $apiSecret);
        $simpleEarnLockedPosition = json_decode(Http::withHeaders([
          'X-MBX-APIKEY' => $apiKey
        ])->get('https://api.binance.com/sapi/v1/simple-earn/locked/position', [
          'timestamp' => $serverTime,
          'signature' => $signature
        ]));
        //dd('simpleEarnLockedPosition', $simpleEarnLockedPosition);
        foreach ($simpleEarnLockedPosition->rows as $key => $value) {
          $earn = Earn::where('positionId', $value->positionId)->first();
          if (!$earn) $earn = new Earn();
          $earn->earn = 'simpleEarnLockedPosition';
          $earn->positionId = $value->positionId;
          $earn->user_id = $user->id;
          $earn->productId = $value->productId;
          $earn->asset = $value->asset;
          $earn->amount = $value->amount;
          $earn->purchaseTime = $value->purchaseTime;
          $earn->duration = $value->duration;
          $earn->accrualDays = $value->accrualDays;
          $earn->rewardAsset = $value->rewardAsset;
          $earn->rewardAmt = $value->rewardAmt;
          $earn->nextPay = $value->nextPay;
          $earn->nextPayDate = $value->nextPayDate;
          $earn->payPeriod = $value->payPeriod;
          $earn->redeemAmountEarly = $value->redeemAmountEarly;
          $earn->rewardsEndDate = $value->rewardsEndDate;
          $earn->deliverDate = $value->deliverDate;
          $earn->redeemPeriod = $value->redeemPeriod;
          $earn->canRedeemEarly = $value->canRedeemEarly;
          $earn->autoSubscribe = $value->autoSubscribe;
          $earn->type = $value->type;
          $earn->status = $value->status;
          $earn->canReStake = $value->canReStake;
          $earn->apy = $value->apy;
          $earn->save();
        }
      } else {
        //dd('simpleEarnLockedPosition', $serverTime, $binance->simple_earn_locked_position);
      }
    }
    $simpleEarnLockedPosition = Earn::whereEarn('simpleEarnLockedPosition')->get();
    return $simpleEarnLockedPosition;
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreEarnRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Earn $earn)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Earn $earn)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateEarnRequest $request, Earn $earn)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Earn $earn)
  {
    //
  }
}
