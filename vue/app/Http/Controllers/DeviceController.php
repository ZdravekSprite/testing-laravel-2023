<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Type;
use App\Models\Owner;
use App\Models\Warehouse;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Http\Requests\DestroyDeviceRequest;
use Inertia\Inertia;

class DeviceController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Inertia::render(
      'Device',
      [
        'devices' => Device::all(),
        'types' => Type::all(),
        'warehouses' => Warehouse::all(),
        'owners' => Owner::all(),
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
  public function store(StoreDeviceRequest $request)
  {
    //dd($request);
    $device = new Device();
    $device->imei = $request->imei;
    $device->gsm = $request->gsm;
    $device->type_id = $request->type;
    $device->warehouse_id = $request->warehouse;
    $device->owner_id = $request->owner;
    $device->description = $request->description;
    $device->save();
  }

  /**
   * Display the specified resource.
   */
  public function show(Device $device)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Device $device)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateDeviceRequest $request, Device $device)
  {
    $device->imei = $request->imei;
    $device->gsm = $request->gsm;
    $device->type_id = $request->type;
    $device->warehouse_id = $request->warehouse;
    $device->owner_id = $request->owner;
    $device->description = $request->description;
    $device->save();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(DestroyDeviceRequest $request, Device $device)
  {
    $device->delete();
  }
}
