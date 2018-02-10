<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use App\User;
use Datatables;
use Response;
use Artisan;

class ActivitylogController extends Controller {
  
	public function index() {
		return view('administrator/activitylog/index');
	}

 	public function getActivitylog(Request $request) {
 		if($request->ajax()){
      $log = Activity::all();
      return Datatables::of($log)
      ->editColumn('causer_id', function ($log) {
        $user = User::where('id', $log->causer_id)->first();
        return $log->causer_id? with($user->name) : '';
      })
      ->editColumn('subject_type', function ($log) {
        return $log->subject_type? with(str_replace('App\\','',$log->subject_type).' (id:'.$log->subject_id.')') : '';
      })
      ->editColumn('created_at', function ($log) {
        return $log->created_at? with(date('M, d Y H:s:i', strtotime($log->created_at))) : '';
      })
      ->make(true);
 		} else {
 			return abort(404);
 		}
 	}

  public function show($id) {
    $log = Activity::find($id);
    $log_properties = $log->properties;
    return view('administrator/activitylog/modal_view',compact('log_properties'));

  }

  public function destroy($id) {
    Activity::find($id)->delete();
    return Response::json(['responseText' => 'Deleted'], 200);
  }

  public function clean() {
    Artisan::call("activitylog:clean");
    $statusMessage = Artisan::output('info');
    return $statusMessage;
  }
}
