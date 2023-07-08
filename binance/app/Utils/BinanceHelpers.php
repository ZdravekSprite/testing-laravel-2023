<?php

namespace App\Utils;

use App\Models\Binance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BinanceHelpers
{
  public static function getHttp($link)
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
      $timeStamp = 'timestamp=' . $serverTime;
      $signature = hash_hmac('SHA256', $timeStamp, $apiSecret);
      $json = json_decode(Http::withHeaders([
        'X-MBX-APIKEY' => $apiKey
      ])->get($link, [
        'timestamp' => $serverTime,
        'signature' => $signature
      ]));
    }
    return $json;
  }
}
