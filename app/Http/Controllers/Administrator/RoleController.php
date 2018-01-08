<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use App\ChildMenu;
use App\ParentMenu;
use Datatables;
use DB;

class RoleController extends Controller {
  
	public function index() {
		return view('administrator/role/index');
	}

 	public function getRole(Request $request) {
 		if($request->ajax()){
      $role = Role::with('permission')->get();
 			return Datatables::of($role)->make(true);
 		} else {
 			return abort(404);
 		}
 	}

 	public function create(){
    $permission = ParentMenu::with('child_menu.permission')->orderBy('no_order')->get();
    return view('administrator/role/modal_add',compact('permission'));
  }

  public function store(Request $request) {
    $this->validate($request, [
      'name' => 'required|unique:permissions,name',
      'display_name' => 'required|unique:permissions,display_name',
      'description' => 'required'
    ]);
    
    $role                 = new Role();
    $role->name           = $request->input('name');
    $role->display_name   = $request->input('display_name');
    $role->description    = $request->input('description');
    $role->save();
    if ($request->input('permission') != NULL){
      $permission = explode(",",$request->input('permission'));
      foreach ($permission as $key => $value) {
        $role->attachPermission($value);
      }
    }
    return response()->json(['responseText' => 'Success'], 200);
  }

  public function show($id) {
    $role = Role::find($id);
    $permission = Permission::pluck('id', 'display_name');
    $tree = ParentMenu::with('child_menu.permission')->get();
    $role_permission = $role->permission->pluck('name', 'name')->toArray();
    return view('administrator/role/modal_show',compact('role','tree','permission', 'role_permission'));
  }

  public function edit($id) {
    $role = Role::find($id);
    $permission = Permission::pluck('id', 'display_name');
    $tree = ParentMenu::with('child_menu.permission')->orderBy('no_order')->get();
    $role_permission = $role->permission->pluck('id', 'id')->toArray();
    return view('administrator/role/modal_edit',compact('role','tree','permission', 'role_permission'));
  }

  public function update(Request $request, $id) {
    $this->validate($request, [
      'name'          => 'required|unique:permissions,name',
      'display_name'  => 'required|unique:permissions,display_name',
      'description'   => 'required'
    ]);

    $role = Role::find($id);
    $role->name = $request->input('name');
    $role->display_name = $request->input('display_name');
    $role->description = $request->input('description');
    $role->save();

    DB::table('permission_role')->where('role_id',$id)->delete();

    if ($request->input('permission') != NULL){
      $permission = explode(",",$request->input('permission'));
      foreach ($permission as $key => $value) {
        $role->attachPermission($value);
      }
    }

    return response()->json(['responseText' => 'Updated'], 200);
    
  }

  public function destroy($id) {
    DB::table('roles')->where('id',$id)->delete();
    DB::table('permission_role')->where('role_id',$id)->delete();
    return response()->json(['responseText' => 'Deleted'], 200);
  }
}
