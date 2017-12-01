<?php

namespace App\Http\Controllers\Cost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Indonesia;
use App\Provinces;
use App\City;
use Auth;
use DB;
use Datatables;
use Carbon\Carbon;

class CityController extends Controller {
  
	public function index() {
		return view('cost/city/index');
	}

  /*Province*/
 	public function getProvince(Request $request) {
 		if($request->ajax()) {
      $provinces = Provinces::all();
 			return Datatables::of($provinces)
      ->editColumn('default_price', function ($provinces) {
        return $provinces->default_price? with("Rp " . number_format($provinces->default_price,0,',','.')) : '';
      })
      ->make(true);
 		} else {
 			return abort(404);
 		}
 	}

 	public function createProvince() {
    return view('cost/city/modal_add_province');
  }

  public function storeProvince(Request $request) {
    $default_price = str_replace(".", "", $request->input('default_price'));
    
    $province = new Provinces();
    $province->default_price     = $default_price;
    $province->save();

    return response()->json(['responseText' => 'Success'], 200);
  }

  public function editProvince($id) {
    $provinces = Provinces::find($id);
    return view('cost/city/modal_edit_province',compact('provinces'));
  }

  public function updateProvince(Request $request, $id) {
    $province = Provinces::find($id);
    $default_price = str_replace(".", "", $request->input('default_price'));
    $province->default_price     = $default_price;
    $province->save();
    return response()->json(['responseText' => 'Updated'], 200);
  }

  /*City*/
  public function getCity(Request $request, $id) {
    if($request->ajax()) {
      $city = City::where('province_id', $id)->get();
      return Datatables::of($city)
      ->editColumn('unit_price', function ($city) {
        return $city->unit_price? with("Rp " . number_format($city->unit_price,0,',','.')) : '';
      })->make(true);
    } else {
     return abort(404);
    }
      return response()->json($city);
  }

  public function getCityData($id) {
    return view('cost/city/get-city-data', compact('id'));
  }

  public function getCityDefault() {
    return view('cost/city/get-city-default');
  }

  public function editCity($id) {
    $city = City::find($id);
    return view('cost/city/modal_edit_city',compact('city'));
  }

  public function updateCity(Request $request, $id) {
    $unit_price = str_replace(".", "", $request->input('unit_price'));
    $province = $request->input('province');
    $city = City::find($id);
    $city->unit_price     = $unit_price;
    $city->save();
    return response()->json(['responseText' => 'Updated'], 200);
  }

}
