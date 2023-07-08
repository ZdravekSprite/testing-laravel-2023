<?php

namespace App\Http\Controllers;

use App\Models\Binance;
use App\Http\Requests\StoreBinanceRequest;
use App\Http\Requests\UpdateBinanceRequest;
use App\Utils\BinanceHelpers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class BinanceController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
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
    $lendingAccount = (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/lending/union/account');
    $positionAmountVos = $lendingAccount->positionAmountVos;
    $allCoinsInformation = (new BinanceHelpers)->getHttp('https://api.binance.com/sapi/v1/capital/config/getall');
    $collection = collect($allCoinsInformation);
    $filtered = $collection->map(function ($coin) use ($positionAmountVos) {
      $lendingAsset = collect($positionAmountVos)->filter(function ($value, $key) use ($coin) {
        return $value->asset == $coin->coin;
      })->first();
      $lending = $lendingAsset ? $lendingAsset->amount * 1 : 0;
      $all = $lending + $coin->free + $coin->locked + $coin->freeze + $coin->withdrawing + $coin->ipoing + $coin->ipoable + $coin->storage;
      return [
        'coin' => $coin->coin,
        'depositAllEnable' => $coin->depositAllEnable,
        'withdrawAllEnable' => $coin->withdrawAllEnable,
        'name' => $coin->name,
        'free' => $coin->free * 1,
        'locked' => $coin->locked * 1,
        'freeze' => $coin->freeze * 1,
        'withdrawing' => $coin->withdrawing * 1,
        'ipoing' => $coin->ipoing * 1,
        'ipoable' => $coin->ipoable * 1,
        'storage' => $coin->storage * 1,
        'lending' => $lending,
        'all' => $all,
        'isLegalMoney' => $coin->isLegalMoney,
        'trading' => $coin->trading,
      ];
    })->filter(function ($value, $key) {
      return $value['all'] > 0;
    })->map(function ($coin) {
      $price = 0;
      if ($coin['coin'] == 'EUR') $price = 1;
      if (!$price) {
        $params = '?symbol=' . $coin['coin'] . 'EUR';
        $ticker = (new BinanceHelpers)->get('https://api.binance.com/api/v3/ticker/price' . $params);
        $price = isset($ticker->price) ? $ticker->price * 1 : 0;
      }
      if (!$price) {
        $params = '?symbol=EUR' . $coin['coin'];
        $ticker = (new BinanceHelpers)->get('https://api.binance.com/api/v3/ticker/price' . $params);
        $price = isset($ticker->price) ? 1 / $ticker->price : 0;
      }
      if (!$price) {
        $BUSD = (new BinanceHelpers)->get('https://api.binance.com/api/v3/ticker/price?symbol=EURBUSD')->price;
        $params = '?symbol=' . $coin['coin'] . 'BUSD';
        $ticker = (new BinanceHelpers)->get('https://api.binance.com/api/v3/ticker/price' . $params);
        $price = isset($ticker->price) ? $ticker->price / $BUSD : 0;
      }
      if (!$price) {
        $params = '?symbol=BUSD' . $coin['coin'];
        $ticker = (new BinanceHelpers)->get('https://api.binance.com/api/v3/ticker/price' . $params);
        $price = isset($ticker->price) ? $BUSD / $ticker->price : 0;
      }
      return  [
        ...$coin,
        'price' => $price,
      ];
    });
    //dd($filtered, $allCoinsInformation);
    //dd($filtered);
    $sum = $filtered->reduce(function ($sum, $value) {
      return $sum + ($value['all'] * $value['price']);
    });
    return view('binance.index', [
      'binance' => $binance,
      'coins' => $filtered,
      'sum' => $sum,
    ]);
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
  public function store(StoreBinanceRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Binance $binance)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Binance $binance)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateBinanceRequest $request, Binance $binance): RedirectResponse
  {
    $user = Auth::user();
    $binance = Binance::whereUserId($user->id)->first();
    if (!$binance) {
      $binance = new Binance();
      $binance->user_id = $user->id;
    }
    $binance->api_key = $request->api_key;
    $binance->api_secret = $request->api_secret;
    $binance->save();
    //dd($request, $binance->first());
    return Redirect::route('binance.index')->with('status', 'binance-updated');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Binance $binance)
  {
    //
  }
}
