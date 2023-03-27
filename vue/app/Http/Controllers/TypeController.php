<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Http\Requests\DestroyTypeRequest;
use Inertia\Inertia;

class TypeController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Inertia::render(
      'Type',
      [
        'types' => Type::all(),
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
  public function store(StoreTypeRequest $request)
  {
    $type = new Type();
    $type->name = $request->name;
    $type->description = $request->description;
    $type->save();
  }

  /**
   * Display the specified resource.
   */
  public function show(Type $type)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Type $type)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateTypeRequest $request, Type $type)
  {
    $type->name = $request->name;
    $type->description = $request->description;
    $type->save();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(DestroyTypeRequest $request, Type $type)
  {
    $type->delete();
  }
}
