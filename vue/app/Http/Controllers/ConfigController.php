<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Http\Requests\StoreConfigRequest;
use App\Http\Requests\UpdateConfigRequest;
use App\Http\Requests\DestroyConfigRequest;
use Inertia\Inertia;

class ConfigController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Inertia::render(
      'Config',
      [
        'configs' => Config::all(),
      ]
    );
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
  public function store(StoreConfigRequest $request)
  {
    $config = new Config();
    $config->name = $request->name;
    $config->description = $request->description;
    $config->save();
  }

  /**
   * Display the specified resource.
   */
  public function show(Config $config)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Config $config)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateConfigRequest $request, Config $config)
  {
    $config->name = $request->name;
    $config->description = $request->description;
    $config->save();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(DestroyConfigRequest $request, Config $config)
  {
    $config->delete();
  }
}
