<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\DestroyRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Inertia\Inertia;

class RoleController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Inertia::render(
      'Role',
      [
        'roles' => Role::all(),
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
  public function store(StoreRoleRequest $request)
  {
    $role = new Role();
    $role->name = $request->name;
    $role->description = $request->description;
    $role->save();
  }

  /**
   * Display the specified resource.
   */
  public function show(Role $role)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Role $role)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateRoleRequest $request, Role $role)
  {
    $role->name = $request->name;
    $role->description = $request->description;
    $role->save();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(DestroyRoleRequest $request, Role $role)
  {
    $role->delete();
  }
}
