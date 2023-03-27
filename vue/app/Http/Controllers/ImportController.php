<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Type;
use App\Models\Warehouse;
use App\Models\Owner;
use App\Http\Requests\ImportRequest;

class ImportController extends Controller
{
  /**
   * Handle the incoming request.
   */
  public function __invoke(ImportRequest $request)
  {
    set_time_limit(0);
    //dd($request);
    $fileName = $request->fileName;
    $csvData = fopen(public_path('temp/' . $fileName), 'r');
    $columns = [];
    $deviceRow = false;
    while (($data = fgetcsv($csvData, 555, ',')) !== false) {
      if ($deviceRow) {
        $this->importDevice((object) array_combine($columns, $data));
        $arrayData[] = array_combine($columns, $data);
      } else {
        $columns = $data;
        $deviceRow = true;
      }
    }
    //dd($arrayData);
  }
  public function importDevice($device): void
  {
    //dd($device);
    if (!Device::where('imei', $device->imei)->first()) {
      $type = trim($device->type) != '' ? Type::where('name',$device->type)->first() : Type::where('name','unknown')->first();
      if ($type) {
        $type_id = $type->id;
      } else {
        $type_id = Type::create([
          'name' => $device->type,
        ])->id;
      }
      $warehouse = !in_array(trim($device->warehouse), ['', 0, '0'])  ? Warehouse::where('name',$device->warehouse)->first() : Warehouse::where('name','unknown')->first();
      if ($warehouse) {
        $warehouse_id = $warehouse->id;
      } else {
        $warehouse_id = Warehouse::create([
          'name' => $device->warehouse,
        ])->id;
      }
      $owner = trim($device->owner) != '' ? Owner::where('name',$device->owner)->first() : Owner::where('name','unknown')->first();
      if ($owner) {
        $owner_id = $owner->id;
      } else {
        $owner_id = Owner::create([
          'name' => $device->owner,
        ])->id;
      }
      //dd($type_id,$warehouse_id,$owner_id);
      Device::create([
        'imei' => $device->imei,
        'gsm' => $device->gsm,
        'type_id' => $type_id,
        'warehouse_id' => $warehouse_id,
        'owner_id' => $owner_id,
        'description' => $device->description,
      ]);
    }
  }
}
