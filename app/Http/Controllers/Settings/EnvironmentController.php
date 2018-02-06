<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Brotzka\DotenvEditor\DotenvEditor;
use Datatables;
use Response;
use View;
use Artisan;

class EnvironmentController extends Controller {
  
	public function index() {
		return view('settings/environment/index');
	}

 	public function getEnv(Request $request) {
 		if($request->ajax()){
      $data = [];
      $env = new DotenvEditor();
      $output = $env->getContent();
      foreach ($output as $key => $value) {
        $data[$key]['name'] = $key;
        $data[$key]['value'] = $value;
      }
      return Datatables::of($data)->make(true);
 		} else {
 		 	return abort(404);
 		}
 	}

  public function create(){
    return view('settings/environment/modal_add');
  }

  public function store(Request $request){
    $env = new DotenvEditor();
    $env->addData([
       $request->input('name') => $request->input('value'),
    ]);

    return response()->json(['responseText' => 'Success'], 200);
  }

  public function edit($name, $value) {
    return view('settings/environment/modal_edit', compact('name', 'value'));
  }

  public function update(Request $request, $name) {
    $env = new DotenvEditor();
    $env->changeEnv([
      $name => $request->value,
    ]);

    return response()->json(['responseText' => 'Updated'], 200); 
  }

  public function destroy($name) {
    $env = new DotenvEditor();
    $env->deleteData([$name]);
    return response()->json(['responseText' => 'Deleted'], 200);
    
  }
}
