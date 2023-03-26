<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Http\Requests\DestroyWarehouseRequest;
use Inertia\Inertia;

class WarehouseController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Inertia::render(
      'Warehouse',
      [
        'warehouses' => Warehouse::all(),
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
  public function store(StoreWarehouseRequest $request)
  {
    $warehouse = new Warehouse();
    $warehouse->name = $request->name;
    $warehouse->description = $request->description;
    $warehouse->save();
  }

  /**
   * Display the specified resource.
   */
  public function show(Warehouse $warehouse)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Warehouse $warehouse)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
  {
    $warehouse->name = $request->name;
    $warehouse->description = $request->description;
    $warehouse->save();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(DestroyWarehouseRequest $request, Warehouse $warehouse)
  {
    $warehouse->delete();
  }
}
