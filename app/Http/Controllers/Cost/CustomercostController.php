<?php

namespace App\Http\Controllers\Cost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CustomerCost;
use App\Provinces;
use App\Customer;
use Auth;
use DB;
use Datatables;
use Indonesia;

class CustomercostController extends Controller {
  
	public function index() {
		return view('cost/customercost/index');
	}

 	public function getCustomercost(Request $request) {
 		if($request->ajax()){
      $customer_cost = CustomerCost::with(['customer','destination_provinces','destination_city', 'origin_provinces', 'origin_city'])->get();
 			return Datatables::of($customer_cost)
      ->editColumn('customer', function ($customer_cost) {
        return $customer_cost->customer? with($customer_cost->customer->name) : '';
      })
      ->editColumn('origin_city', function ($customer_cost) {
        return $customer_cost->origin_city? with($customer_cost->origin_city->name.', '.$customer_cost->origin_provinces->name) : '';
      })
      ->editColumn('destination_city', function ($customer_cost) {
        return $customer_cost->destination_city? with($customer_cost->destination_city->name.', '.$customer_cost->destination_provinces->name) : '';
      })
      ->editColumn('cost', function ($customer_cost) {
        return $customer_cost->cost? with("Rp " . number_format($customer_cost->cost,0,',','.')) : '';
      })
      ->make(true);
 		} else {
      return abort(404);
 		}
 	}

 	public function create() {
    $customer = Customer::all()->pluck('name','id');
    $province = Indonesia::allProvinces()->pluck('name','id');
    return view('cost/customercost/modal_add', compact('province', 'customer'));
 	}

  public function store(Request $request) {
    $this->validate($request, [
      'customer'          => 'required',
      'org_provinces'     => 'required',
      'org_city'          => 'required',
      'dest_provinces'    => 'required',
      'dest_city'         => 'required',
      'type'              => 'required'
    ]);

    $cost                                     = str_replace(".", "", $request->input('cost'));
    $customercost                             = new CustomerCost();
    $customercost->customer_id                = $request->input('customer');
    $customercost->origin_provinces_id        = $request->input('org_provinces');
    $customercost->origin_city_id             = $request->input('org_city');
    $customercost->destination_provinces_id   = $request->input('dest_provinces');
    $customercost->destination_city_id        = $request->input('dest_city');
    $customercost->type                       = $request->input('type');
    $customercost->cost                       = $cost;
    $customercost->created_by                 = Auth::user()->id;
    $customercost->save();

    return response()->json(['responseText' => 'Success'], 200);
  }

  public function edit($id) {
    $customercost           = CustomerCost::find($id);
    $province               = Indonesia::allProvinces()->pluck('name','id');
    $customer               = Customer::all()->pluck('name','id');
    $customer_cost_customer = $customercost->customer_id;
    $org_provinces          = $customercost->origin_provinces_id;
    $org_city               = $customercost->origin_city_id;
    $city_org               = Indonesia::findProvince($org_provinces, ['cities']);
    $city_org               = null === $city_org ? [] : $city_org->cities->pluck('name', 'id')->toArray();
    $dest_provinces         = $customercost->destination_provinces_id;
    $dest_city              = $customercost->destination_city_id;
    $city_dest              = Indonesia::findProvince($dest_provinces, ['cities']);
    $city_dest              = null === $city_dest ? [] : $city_dest->cities->pluck('name', 'id')->toArray();

    return view(
      'cost/customercost/modal_edit',
        compact(
          'customercost',
          'customer',
          'customer_cost_customer',
          'org_provinces',
          'city_org',
          'org_city',                                             
          'dest_provinces',
          'dest_city',
          'city_dest',
          'province'                                               
        )
    );
  }

  public function update(Request $request, $id) {
    $this->validate($request, [
      'customer'          => 'required',
      'org_provinces'     => 'required',
      'org_city'          => 'required',
      'dest_provinces'    => 'required',
      'dest_city'         => 'required',
      'type'              => 'required'
    ]);

    $cost                                     = str_replace(".", "", $request->input('cost'));
    $customercost                             = CustomerCost::find($id);
    $customercost->customer_id                = $request->input('customer');
    $customercost->origin_provinces_id        = $request->input('org_provinces');
    $customercost->origin_city_id             = $request->input('org_city');
    $customercost->destination_provinces_id   = $request->input('dest_provinces');
    $customercost->destination_city_id        = $request->input('dest_city');
    $customercost->type                       = $request->input('type');
    $customercost->cost                       = $cost;
    $customercost->updated_by                 = Auth::user()->id;
    $customercost->save();
    return response()->json(['responseText' => 'Updated'], 200);
  }

  public function destroy($id) {
    $delete_customercost = CustomerCost::find($id);
    $delete_customercost->delete();
    return response()->json(['responseText' => 'Deleted'], 200);
  }
}
