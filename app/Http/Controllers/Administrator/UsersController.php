<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use DB;
use Hash;
use Datatables;

class UsersController extends Controller {
  
	public function index() {
		return view('administrator/users/index');
	}

 	public function getUser(Request $request) {
 		if($request->ajax()){
      $users = User::with('roles')->get();
 			return Datatables::of($users)
      ->editColumn('roles', function ($users) {
        return $users->roles? with($users->roles[0]->display_name) : '';})
      ->make(true);
 		} else {
 			return abort(404);
 		}
 	}

 	public function create() {
    $roles = Role::pluck('display_name','id')->toArray();
    return view('administrator/users/modal_add',compact('roles'));
 	}

  public function store(Request $request) {
    $this->validate($request, [
      'name'      => 'required',
      'username'  => 'required|unique:users,username',
      'email'     => 'required|email|unique:users,email',
      'password'  => 'required|same:confirm-password',
      'roles'     => 'required'
    ]);

    $user             = new User();
    $user->name       = $request->input('name');
    $user->username   = $request->input('username');
    $user->email      = $request->input('email');
    $user->password   = Hash::make($request->input('password'));
    $user->photo      = 'default.jpg';
    $user->save();
    $user->attachRole($request->input('roles'));

    return response()->json(['responseText' => 'Success'], 200);
  }

  public function edit($id) {
    $user       = User::find($id);
    $roles      = Role::pluck('display_name','id')->toArray();
    $userRole   = $user->roles_id;
    return view('administrator/users/modal_edit',compact('user','roles','userRole'));
  }

  public function update(Request $request, $id) {
    $user       = User::find($id);
    $this->validate($request, [
        'name'      => 'required',
        'username'  => 'required|unique:users,username,'.$user->id,
        'email'     => 'required|email|unique:users,email,'.$user->id,
        'password'  => 'same:confirm-password',
        'roles'     => 'required'
    ]);

    $user             = User::find($id);
    $user->name       = $request->input('name');
    $user->username   = $request->input('username');
    $user->email      = $request->input('email');
    if(!empty($request->input('password'))){ 
      $user->password = Hash::make($request->input('password'));
    }
    $user->save();

    $user->roles()->detach();
    $user->attachRole($request->input('roles'));

    return response()->json(['responseText' => 'Updated'], 200);
  }

  public function destroy($id) {
    $user_delete = User::find($id);
    $user_delete->delete();
    return response()->json(['responseText' => 'Deleted'], 200);
  }
}
