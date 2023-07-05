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
use Illuminate\Contracts\Database\Eloquent\Builder;

class DeviceController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index($type = null)
  {
    if ($type) {
      //dd(Type::find($type));
      //$devices = Type::find($type)->devices()->get();
      $types = Type::where('description', 'LIKE', '%' . $type . '%')->pluck('id');
      //dd($types);
      $devices = Device::whereIn('type_id', $types);
    } else {
      $devices = Type::find(1)->devices();
    }
    $devices = $devices->paginate(10);
    return Inertia::render(
      'Device',
      [
        'devices' => $devices,
/*        'devices' => $devices->map(fn ($d) => [
          'id' => $d->id,
          'imei' => $d->imei,
          'gsm' => $d->gsm,
          'type' => $d->type,
          'type_id' => $d->type_id,
          'warehouse' => $d->warehouse,
          'warehouse_id' => $d->warehouse_id,
          'owner' => $d->owner,
          'owner_id' => $d->owner_id,
          'description' => $d->description,
        ]),*/
        'types' => Type::all()->map(fn ($t) => [
          'id' => $t->id,
          'name' => $t->name,
          'description' => $t->description,
        ]),
        'warehouses' => Warehouse::all()->map(fn ($w) => [
          'id' => $w->id,
          'name' => $w->name,
          'description' => $w->description,
        ]),
        'owners' => Owner::all()->map(fn ($o) => [
          'id' => $o->id,
          'name' => $o->name,
          'description' => $o->description,
        ]),
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
