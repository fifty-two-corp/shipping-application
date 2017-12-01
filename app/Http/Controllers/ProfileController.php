<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;
use Illuminate\Support\Facades\Input;

class ProfileController extends Controller
{
  public function index() {
  	return view('profile/profile');
  } 

  public function update_pictures(Request $request) {
    $id             = Auth::user()->id;
  	$user           = Auth::user()->username;
    $image          = Input::file('image');
    $ext            = Input::get('ext');
    $fileName       = $id.'_'.$user.'.'.$ext;
    
    $photo          = User::find($id);
    $photo->photo   = $fileName;
    $photo->save();
    if($photo) {
      $image->move('photo', $fileName);
     };
    return response()->json($ext);
  }

  public function update_field(Request $request) {
    $id = Auth::user()->id;

    if($request->ajax()){
        User::find($id)->update([$request->get('name') => $request->get('value')]);
        return response()->json(['success'=>true]);
    }
  }

  public function update_password() {
    return view('profile/modal_password');
  }

  public function store_password(Request $request) {
    
    $this->validate($request, [
      'new_password' => 'required|same:confirm-password',
    ]);

    $user = Auth::user();

    $curPassword = $request->current_password;
    $newPassword = $request->new_password;

    if (Hash::check($curPassword, $user->password)) {
      $user_id = $user->id;
      $obj_user = User::find($user_id)->first();
      $obj_user->password = Hash::make($newPassword);
      $obj_user->save();

      return response()->json(["result"=>true]);
    }
  }
}
