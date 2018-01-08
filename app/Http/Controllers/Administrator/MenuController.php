<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Permission;
use App\ParentMenu;
use App\ChildMenu;
use DB;
use Datatables;

class MenuController extends Controller {
  
	public function index() {
		return view('administrator/menu/index');
	}

 	public function getParentMenu(Request $request) {
 		if($request->ajax()){
      $parent_menu = ParentMenu::orderBy('no_order');
 			return Datatables::of($parent_menu)->make(true);
 		} else {
      return abort(404);
 		}
 	}

  public function getChildMenu($id) {
    if($request->ajax()){
      $child_menu = ChildMenu::where('parent_menu_id',$id);
      return Datatables::of($child_menu)->make(true);
    } else {
      return abort(404);
    }
  }

 	public function create() {
    $child_menu = ChildMenu::pluck('name','id');
    return view('administrator/permision/modal_add', compact('child_menu'));
 	}

  public function store(Request $request) {
    $this->validate($request, [
      'name'          => 'required|unique:permissions,name',
      'display_name'  => 'required|unique:permissions,display_name',
      'description'   => 'required',
    ]);
    $input        = $request->all();
    $child_menu   = $request->input('child_menu');
    $permision    = Permission::create($input);
    $permision->permission()->attach($child_menu);
    
    return response()->json(['responseText' => 'Success'], 200);
  }

  public function edit($id) {
    $permision            = Permission::find($id);
    $child_menu           = ChildMenu::pluck('name','id');
    $permision_child_menu = $permision->permission->pluck('id', 'id')->toArray();

    return view('administrator/permision/modal_edit',compact('permision', 'child_menu', 'permision_child_menu'));
  }

  public function update(Request $request, $id) {
    $this->validate($request, [
      'name'          => 'required',
      'display_name'  => 'required',
      'description'   => 'required',
    ]);

    $input        = $request->all();
    $child_menu   = $request->input('child_menu');
    $permision    = Permission::find($id);
    $permision->update($input);
    DB::table('child_menu_permission')->where('permission_id',$id)->delete();
    $permision->permission()->attach($child_menu);

    return response()->json(['responseText' => 'Updated'], 200);
  }

  public function destroy($id) {
    Permission::find($id)->delete();
    return response()->json(['responseText' => 'Deleted'], 200);
  }
}
