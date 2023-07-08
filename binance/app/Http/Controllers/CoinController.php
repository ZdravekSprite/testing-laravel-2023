<?php

namespace App\Http\Controllers;

use App\Models\Binance;
use App\Models\Coin;
use App\Models\Network;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCoinRequest;
use App\Http\Requests\UpdateCoinRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CoinController extends Controller
{
  public function chart(Request $request)
  {
    $show = $request->input('show');
    $trades = collect([]);
    $symbols_list = ['ETH', 'BNB', 'SOL', 'MATIC', 'ADA', 'DOT', 'XMR'];
    $symbols = [
      ['BTCBUSD', [], [], [], '1d'],
      ['BTCBUSD', [], [], [], '1h'],
      ['BTCBUSD', [], [], [], '1m']
    ];
    foreach ($symbols_list as $symbol) {
      $symbols[] = [$symbol . 'BTC', [], [], [], '1h'];
      $symbols[] = [$symbol . 'BUSD', [], [], [], '1d'];
      $symbols[] = [$symbol . 'BUSD', [], [], [], '1h'];
      $symbols[] = [$symbol . 'BUSD', [], [], [], '1m'];
    }
    $symbols[] = ['BTCEUR', [], [], [], '1h'];
    $symbols[] = ['EURBUSD', [], [], [], '1d'];
    $symbols[] = ['EURBUSD', [], [], [], '1h'];
    $symbols[] = ['EURBUSD', [], [], [], '1m'];
    foreach ($symbols as $key => $symbol) {
      $symbol_info = '';
      $symbols[$key][5] = 5;
      if (isset($openOrders)) {
        foreach ($openOrders as $order) {
          if ($order->symbol == $symbol[0]) {
            if ($order->side == 'BUY') {
              $symbols[$key][1][$order->orderId] = $order->price;
            }
            if ($order->side == 'SELL') {
              $symbols[$key][2][$order->orderId] = $order->price;
            }
          }
        }
      }
    }
    $func = function ($n) {
      return strtolower($n[0]) . '@kline_1m';
    };
    $link = implode('/', array_map($func, $symbols));

    $chartWidth = 627; //313 470 627;
    $chartWidth_btc = 417; // 207 417
    $chartHeight = 310; //230 310 465;
    switch ($show) {
      case 'all':
        $chartWidth = 313;
        $chartWidth_btc = 207;
        $chartHeight = 310;
        break;
      case 'big':
        $chartWidth = 627;
        $chartWidth_btc = 417;
        $chartHeight = 310;
        break;
      case 'one':
        $chartWidth = 627;
        $chartWidth_btc = 417;
        $chartHeight = 465;
        break;
    }
    return view('chart')->with(compact('symbols', 'link', 'chartWidth', 'chartWidth_btc', 'chartHeight'));
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $coins = Coin::all();
    return view('coin.index', [
      'coins' => $coins,
    ]);
  }

  public function capitalConfigGetall()
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
      if ($binance->capital_config_getall + $binance->timeout < $serverTime) {
        $binance->capital_config_getall = $serverTime;
        $binance->save();
        $timeStamp = 'timestamp=' . $serverTime;
        $signature = hash_hmac('SHA256', $timeStamp, $apiSecret);
        $capitalConfigGetall = json_decode(Http::withHeaders([
          'X-MBX-APIKEY' => $apiKey
        ])->get('https://api.binance.com/sapi/v1/capital/config/getall', [
          'timestamp' => $serverTime,
          'signature' => $signature
        ]));
        foreach ($capitalConfigGetall as $key => $value) {
          $coin = Coin::whereCoin($value->coin)->first();
          if (!$coin) $coin = new Coin();
          $coin->coin = $value->coin;
          $coin->user_id = $user->id;
          $coin->depositAllEnable = $value->depositAllEnable;
          $coin->withdrawAllEnable = $value->withdrawAllEnable;
          $coin->name = $value->name;
          $coin->free = $value->free;
          $coin->locked = $value->locked;
          $coin->freeze = $value->freeze;
          $coin->withdrawing = $value->withdrawing;
          $coin->ipoing = $value->ipoing;
          $coin->ipoable = $value->ipoable;
          $coin->storage = $value->storage;
          $coin->isLegalMoney = $value->isLegalMoney;
          $coin->trading = $value->trading;
          $coin->save();
          foreach ($value->networkList as $k => $v) {
            $network = Network::whereCoinId($coin->id)
              ->whereNetwork($v->network)
              ->whereCoin($v->coin)
              ->first();
            if (!$network) $network = new Network();
            $network->coin_id = $coin->id;
            $network->network = $v->network;
            $network->coin = $v->coin;
            $network->entityTag = $v->entityTag;
            $network->withdrawIntegerMultiple = $v->withdrawIntegerMultiple;
            $network->isDefault = $v->isDefault;
            $network->depositEnable = $v->depositEnable;
            $network->withdrawEnable = $v->withdrawEnable;
            $network->depositDesc = $v->depositDesc;
            $network->withdrawDesc = $v->withdrawDesc;
            $network->specialTips = $v->specialTips ?? '';
            $network->specialWithdrawTips = $v->specialWithdrawTips ?? '';
            $network->name = $v->name;
            $network->resetAddressStatus = $v->resetAddressStatus;
            $network->addressRegex = $v->addressRegex;
            $network->addressRule = $v->addressRule;
            $network->memoRegex = $v->memoRegex;
            $network->withdrawFee = $v->withdrawFee;
            $network->withdrawMin = $v->withdrawMin;
            $network->withdrawMax = $v->withdrawMax;
            $network->minConfirm = $v->minConfirm;
            $network->unLockConfirm = $v->unLockConfirm;
            $network->sameAddress = $v->sameAddress;
            $network->estimatedArrivalTime = $v->estimatedArrivalTime;
            $network->busy = $v->busy;
            $network->country = $v->country ?? '';
            $network->contractAddressUrl = $v->contractAddressUrl ?? '';
            $network->contractAddress = $v->contractAddress ?? '';
            $network->save();
          }
        }
      } else {
        //dd('capitalConfigGetall', $serverTime, $binance->capital_config_getall);
      }
    }
    $capitalConfigGetall = Coin::all();
    return $capitalConfigGetall;
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
  public function store(StoreCoinRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Coin $coin)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Coin $coin)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateCoinRequest $request, Coin $coin)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Coin $coin)
  {
    //
  }
}
