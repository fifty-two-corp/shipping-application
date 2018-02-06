<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Datatables;
use Response;
use View;
use Artisan;

class LogController extends Controller {
  
	public function index() {
		return view('administrator/backup/index');
	}

 	public function getBackupData(Request $request) {
 		//if($request->ajax()){
      $data = [];
      $filesInFolder = Storage::disk('local')->files('backup');
      foreach($filesInFolder as $key => $file)
      {
        $data[$key]['name'] = str_replace("backup/", "", $file);
        $data[$key]['size'] = number_format(Storage::disk('local')->size($file) / 1048576, 2).' MB';
        $data[$key]['mime'] = Storage::disk('local')->mimeType($file);
        $data[$key]['last_modified'] = date("d-M-Y H:i:s",Storage::disk('local')->lastModified($file));
      }
 			return Datatables::of($data)->make(true);
 		// } else {
 		// 	return abort(404);
 		// }
 	}

 	public function backup(){
    Artisan::call('backup:run');
  }

  public function download($name) {
    return response()->download(storage_path("app/backup/{$name}"));
  }

  public function destroy($name) {
    $delete = Storage::delete('backup/'.$name);
    return Response::json($delete);
    
  }
}
