<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Settings;
use Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SettingsController extends Controller {
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
      $settings = Settings::all();
		  return view('administrator/settings/index', compact('settings'));
	  }

  /**
   * @param Request $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function save_data_bank(Request $request, $id) {
      $settings = Settings::find($id);
      $settings->bank_name    = $request->bank_name;
      $settings->bank_account = $request->bank_account;
      $settings->bank_number  = $request->bank_number;
      $settings->save();
      return Response::json(['responseText' => 'Updated'], 200);
    }

    public function shell(Request $request) {
      $datax =[];
      $process = new Process(array('ls', '-lsa'));
      $process->start();

      foreach ($process as $type => $data) {
        if ($process::OUT === $type) {
          $datax[]=$data;
        } else { // $process::ERR === $type
          echo "\nRead from stderr: ".$data;
        }
      }
      return Response::json($datax);
    }
}
