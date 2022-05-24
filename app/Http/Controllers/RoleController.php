<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $roles = Role::withCount('permissions')->get();
      return response()->view('spatie.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return response()->view('spatie.roles.create');
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
      $roles = Role::create($input);

      if ($roles) {
        session()->flash('add');
        return redirect()->route('roles.index');
      } else {
        session()->flash('not_add');
        return redirect()->route('roles.index');
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
      dd('function show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $role = Role::findOrFail($id);
      return view('spatie.roles.edit', compact('role'));
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
      $role = Role::findOrFail($id);
      $input = $request->all();
      $request->validate([
        'guard_name' => 'bail|required|string',
        'name'       => 'bail|required|string',
      ]);

      $updateRole = $role->update($input);
      if ($updateRole) {
        session()->flash('update');
        return redirect()->route('roles.index');
      }else {
        return redirect()->route('roles.index');
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
      // dd('delete');
      $role = Role::destroy($id);
      if ($role) {
        session()->flash('delete');
        return redirect()->route('roles.index');
      }else {
        return redirect()->route('roles.index');
      }
    }


}
