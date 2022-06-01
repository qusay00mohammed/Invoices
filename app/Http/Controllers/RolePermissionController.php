<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
  public function index($role_id)
  {

    $role = Role::find($role_id);
    $permission = Permission::get();
    $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role_id)
    ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
    ->all();

    // $role = Role::find($role_id);
    // $permission = Permission::all();
    // $rolePermissions = Role::findOrFail($role_id)->permissions;
    // $rolePermissions = Permission::where('id', $role_id)->get();

    // if(count($rolePermissions) > 0) {
    //   foreach ($permissions as $key => $permission) {
    //     $permission->setAttribute('active', false);
    //     foreach ($rolePermissions as $key => $rolepermission) {
    //       if($rolepermission->id == $permission->id) {
    //         $permission->active = true;
    //       }
    //     }
    //   }
    // }

    return view('spatie.roles.role-permission', compact('permission', 'rolePermissions', 'role'));
  }

  // public function store(Request $request, $role_id)
  // {
  //   $request->validate([
  //     'permission_id' => 'required|exists:permissions,id',
  //   ]);
  //   $role = Role::findOrFail($role_id);
  //   $permission = Permission::findOrFail($request->get('permission_id'));

  //   if($role->hasPermissionTo($permission->id)){
  //     $role->revokePermissionTo($permission->id);

  //   }else{
  //     $role->givePermissionTo($permission->id);
  //   }
  //   return  redirect()->back();
  // }

  public function update(Request $request, $id)
    {
    $this->validate($request, [
    'name' => 'required',
    'permission' => 'required',
    ]);
    $role = Role::find($id);
    $role->name = $request->input('name');
    $role->save();
    $role->syncPermissions($request->input('permission'));
    return redirect()->route('roles.index')
    ->with('success','Role updated successfully');
    }



}
