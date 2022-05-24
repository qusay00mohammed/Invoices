<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $permissions = Permission::all();
    return response()->view('spatie.permissions.index', compact('permissions'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return response()->view('spatie.permissions.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $input = $request->all();
      $request->validate([
        'name'       => 'bail|required|string',
        'guard_name' => 'bail|required|string',
      ]);
      $permission = Permission::create($input);

      if ($permission) {
        session()->flash('add');
        return redirect()->route('permissions.index');
      } else {
        session()->flash('not_add');
        return redirect()->route('permissions.index');
      }

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    dd('qweqwe');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $permission = Permission::findOrFail($id);
    return response()->view('spatie.permissions.edit', compact('permission'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $permission = Permission::findOrFail($id);
    $input = $request->all();
      $request->validate([
        'name'       => 'bail|required|string',
        'guard_name' => 'bail|required|string',
      ]);

      $updatePermission = $permission->update($input);

      if ($updatePermission) {
        session()->flash('update');
        return redirect()->route('permissions.index');
      } else {
        return redirect()->route('permissions.index');
      }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $permission = Permission::destroy($id);
    session()->flash('delete');
    return redirect()->route('permissions.index');
  }
}
