<?php

namespace App\Http\Controllers;

use App\Models\Binance;
use App\Http\Requests\StoreBinanceRequest;
use App\Http\Requests\UpdateBinanceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
    if ($binance->api_key != '' && $binance->api_secret != '') {
      $apiKey = $binance->api_key;
      $apiSecret = $binance->api_secret;
      $time = json_decode(Http::get('https://api.binance.com/api/v3/time'));
      $serverTime = $time->serverTime;
      $timeStamp = 'timestamp=' . $serverTime;
      $signature = hash_hmac('SHA256', $timeStamp, $apiSecret);
      $getall = json_decode(Http::withHeaders([
        'X-MBX-APIKEY' => $apiKey
      ])->get('https://api.binance.com/sapi/v1/capital/config/getall', [
        'timestamp' => $serverTime,
        'signature' => $signature
      ]));
      //dd($getall);
    }
    return view('binance.index', [
      'binance' => $binance,
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
