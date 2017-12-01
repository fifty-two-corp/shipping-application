<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Permission;
use App\ParentMenu;
use App\ChildMenu;
use Auth;
use DB;
use Datatables;

class MenuPermissionController extends Controller {
  
	public function index() {
		return view('administrator/menu_permission/index');
	}

  //Parent Menu
  public function getParentMenu(Request $request) {
    if($request->ajax()){
      $parent_menu = ParentMenu::orderBy('no_order');
      return Datatables::of($parent_menu)->make(true);
    } else {
      return abort(404);
    }
  }

  public function createParentMenu() {
    return view('administrator/menu_permission/modal_add_parent');
  }

  public function storeParentMenu(Request $request) {
    $this->validate($request, [
      'name'  => 'required|unique:parent_menu,name',
      'icon'  => 'required|unique:parent_menu,icon'
    ]);
    $parent_menu              = new ParentMenu();
    $parent_menu->name        = $request->input('name');
    $parent_menu->icon        = $request->input('icon');
    $parent_menu->created_by  = Auth::user()->id;
    $parent_menu->save();
    return response()->json(['responseText' => 'Success'], 200);
  }

  public function editParentMenu($id) {
    $parent_menu = ParentMenu::find($id);
    return view('administrator/menu_permission/modal_edit_parent', compact('parent_menu'));
  }

  public function updateParentMenu(Request $request, $id) {
    $parent_menu = ParentMenu::find($id);
    $this->validate($request, [
      'name'  => 'required|unique:parent_menu,name,'.$parent_menu->id,
      'icon'  => 'required|unique:parent_menu,icon,'.$parent_menu->id
    ]);
    $parent_menu->name        = $request->input('name');
    $parent_menu->icon        = $request->input('icon');
    $parent_menu->updated_by  = Auth::user()->id;
    $parent_menu->save();
    return response()->json(['responseText' => 'Updated'], 200);
  }

  public function destroyParentMenu($id) {
    $parent_menu = ParentMenu::find($id);
    $parent_menu->deleted_by = Auth::user()->id;
    $parent_menu->save();
    $parent_menu->delete();
    return response()->json(['responseText' => 'Deleted'], 200);
  }


  // Child Menu
  public function getChildMenuDefault() {
    return view('administrator/menu_permission/get-child-default');
  }

  public function getChildMenuData($id) {
    return view('administrator/menu_permission/get-child-data', compact('id'));
  }

  public function getDataChild(Request $request, $id) {
    if($request->ajax()){
      $parent_menu = ChildMenu::where('parent_menu_id', $id)->get();
      return Datatables::of($parent_menu)->make(true);
    } else {
      return abort(404);
    }
  }

  public function createChildMenu() {
    $parent_menu = ParentMenu::pluck('name','id')->toArray();
    return view('administrator/menu_permission/modal_add_child',compact('parent_menu'));
  }

  public function storeChildMenu(Request $request) {
    $this->validate($request, [
      'name'  => 'required|unique:child_menu,name',
      'link'  => 'required|unique:child_menu,link'
    ]);
    $child_menu                   = new ChildMenu();
    $child_menu->name             = $request->input('name');
    $child_menu->link             = $request->input('link');
    $child_menu->parent_menu_id   = $request->input('parent_menu');
    $child_menu->created_by       = Auth::user()->id;
    $child_menu->save();
    return response()->json(['responseText' => 'Success'], 200);
  }

  public function editChildMenu($id) {
    $child_menu         = ChildMenu::find($id);
    $parent_menu        = ParentMenu::pluck('name','id')->toArray();
    $parent_child_menu  = $child_menu->parent_menu_id;
    return view('administrator/menu_permission/modal_edit_child',
      compact(
        'child_menu',
        'parent_menu',
        'parent_child_menu'
      )
    );
  }

  public function updateChildMenu(Request $request, $id) {
    $child_menu = ChildMenu::find($id);
    $this->validate($request, [
      'name'  => 'required|unique:child_menu,name,'.$child_menu->id,
      'link'  => 'required|unique:child_menu,link,'.$child_menu->id
    ]);
    $child_menu->name            = $request->input('name');
    $child_menu->link            = $request->input('link');
    $child_menu->parent_menu_id  = $request->input('parent_menu');
    $child_menu->updated_by      = Auth::user()->id;
    $child_menu->save();
    return response()->json(['responseText' => 'Updated'], 200);
  }

  public function destroyChildMenu($id) {
    $child_menu = ChildMenu::find($id);
    $child_menu->deleted_by = Auth::user()->id;
    $child_menu->save();
    $child_menu->delete();
    return response()->json(['responseText' => 'Deleted'], 200);
  }

  // Permission
  public function getPermissionDefault() {
    return view('administrator/menu_permission/get-permission-default');
  }

  public function getPermissionData($id) {
    return view('administrator/menu_permission/get-permission-data', compact('id'));
  }

 	public function getDataPermission(Request $request, $id) {
 		if($request->ajax()){
      $permission = Permission::where('child_menu_id', $id)->get();
 			return Datatables::of($permission)->make(true);
 		} else {
      return abort(404);
 		}
 	}

 	public function createPermission() {
    $child_menu = ChildMenu::pluck('name','id')->toArray();
    return view('administrator/menu_permission/modal_add_permission', compact('child_menu'));
 	}

  public function storePermission(Request $request) {
    $this->validate($request, [
      'name'          => 'required|unique:permissions,name',
      'display_name'  => 'required|unique:permissions,display_name',
      'description'   => 'required',
      'child_menu'    => 'required'
    ]);
    $permission                  = new Permission();
    $permission->name            = $request->input('name');
    $permission->display_name    = $request->input('display_name');
    $permission->description     = $request->input('description');
    $permission->child_menu_id   = $request->input('child_menu');
    $permission->created_by      = Auth::user()->id;
    $permission->save();
    return response()->json(['responseText' => 'Success'], 200);
  }

  public function editPermission($id) {
    $permission             = Permission::find($id);
    $child_menu             = ChildMenu::pluck('name','id');
    $permision_child_menu   = $permission->child_menu_id;
    return view('administrator/menu_permission/modal_edit_permission',compact('permission', 'child_menu', 'permision_child_menu'));
  }

  public function updatePermission(Request $request, $id) {
    $permission = Permission::find($id);
    $this->validate($request, [
      'name'          => 'required|unique:permissions,name,'.$permission->id.',deleted_at,NULL',
      'display_name'  => 'required',
      'description'   => 'required',
      'child_menu'    => 'required',
    ]);
    $permission->name            = $request->input('name');
    $permission->display_name    = $request->input('display_name');
    $permission->description     = $request->input('description');
    $permission->child_menu_id   = $request->input('child_menu');
    $permission->updated_by      = Auth::user()->id;
    $permission->save();
    return response()->json(['responseText' => 'Updated'], 200);
  }

  public function destroyPermission($id) {
    $permission               = Permission::find($id);
    $permission_name          = $permission->name .'-'. $id;
    $permission_display_name  = $permission->display_name .' '. $id;
    $permission->display_name = $permission_display_name;
    $permission->name         = $permission_name;
    $permission->deleted_by   = Auth::user()->id;
    $permission->save();
    $permission->delete();
    return response()->json(['responseText' => 'Deleted'], 200);
  }
}
