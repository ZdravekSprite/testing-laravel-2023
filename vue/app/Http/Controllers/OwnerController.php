<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Http\Requests\StoreOwnerRequest;
use App\Http\Requests\UpdateOwnerRequest;
use App\Http\Requests\DestroyOwnerRequest;
use Inertia\Inertia;

class OwnerController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Inertia::render(
      'Owner',
      [
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
  public function store(StoreOwnerRequest $request)
  {
    $owner = new Owner();
    $owner->name = $request->name;
    $owner->description = $request->description;
    $owner->save();
  }

  /**
   * Display the specified resource.
   */
  public function show(Owner $owner)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Owner $owner)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateOwnerRequest $request, Owner $owner)
  {
    $owner->name = $request->name;
    $owner->description = $request->description;
    $owner->save();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(DestroyOwnerRequest $request, Owner $owner)
  {
    $owner->delete();
  }
}
