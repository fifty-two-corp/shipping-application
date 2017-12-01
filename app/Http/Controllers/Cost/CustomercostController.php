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
      $customer_cost = CustomerCost::with(['customer','destination_provinces','origin_provinces'])->get();
 			return Datatables::of($customer_cost)
      ->editColumn('customer', function ($customer_cost) {
        return $customer_cost->customer? with($customer_cost->customer->name) : '';
      })
      ->editColumn('origin_provinces', function ($customer_cost) {
        return $customer_cost->origin_provinces? with($customer_cost->origin_provinces->name) : '';
      })
      ->editColumn('destination_provinces', function ($customer_cost) {
        return $customer_cost->destination_provinces? with($customer_cost->destination_provinces->name) : '';
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
      'dest_provinces'    => 'required',
      'type'              => 'required'
    ]);

    $cost                                     = str_replace(".", "", $request->input('cost'));
    $customercost                             = new CustomerCost();
    $customercost->customer_id                = $request->input('customer');
    $customercost->origin_provinces_id        = $request->input('org_provinces');
    $customercost->destination_provinces_id   = $request->input('dest_provinces');
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
    $dest_provinces         = $customercost->destination_provinces_id;
    $province               = Indonesia::allProvinces()->pluck('name','id');

    return view(
      'cost/customercost/modal_edit',
        compact(
          'customercost',
          'customer',
          'customer_cost_customer',
          'org_provinces',                                             
          'dest_provinces',
          'province'                                               
        )
    );
  }

  public function update(Request $request, $id) {
    $this->validate($request, [
      'customer'          => 'required',
      'org_provinces'     => 'required',
      'dest_provinces'    => 'required',
      'type'              => 'required'
    ]);

    $cost                                     = str_replace(".", "", $request->input('cost'));
    $customercost                             = CustomerCost::find($id);
    $customercost->customer_id                = $request->input('customer');
    $customercost->origin_provinces_id        = $request->input('org_provinces');
    $customercost->destination_provinces_id   = $request->input('dest_provinces');
    $customercost->type                       = $request->input('type');
    $customercost->cost                       = $cost;
    $customercost->updated_by                 = Auth::user()->id;
    $customercost->save();
    return response()->json(['responseText' => 'Updated'], 200);
  }

  public function destroy($id) {
    $delete_customercost = Customer::find($id);
    $delete_customercost->deleted_by = Auth::user()->id;
    $delete_customercost->save();
    $delete_customercost->delete();
    return response()->json(['responseText' => 'Deleted'], 200);
  }
}
