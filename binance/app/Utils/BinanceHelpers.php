<?php

namespace App\Utils;

use App\Models\Binance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BinanceHelpers
{
  public function getHttp($url, $array = null)
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
      $timestampArray = array(
        "timestamp" => $serverTime
      );
      $queryArray = $array ? $array + $timestampArray : $timestampArray;
      $signature = hash_hmac('SHA256', http_build_query($queryArray), $apiSecret);
      $signatureArray = array("signature" => $signature);
      $getArray = $queryArray + $signatureArray;
      $json = json_decode(Http::withHeaders([
        'X-MBX-APIKEY' => $apiKey
      ])->get($url, $getArray));
    }
    return $json;
  }
  public function get($url)
  {
    $http_get = json_decode(Http::get($url));
    return $http_get;
  }
}
