<?php

namespace App\Http\Controllers\Cost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VendorCost;
use App\Vendor;
use App\Provinces;
use App\Customer;
use Auth;
use DB;
use Datatables;
use Indonesia;

class VendorcostController extends Controller {
  
	public function index() {
		return view('cost/vendorcost/index');
	}

 	public function getVendorcost(Request $request) {
 		if($request->ajax()){
      $vendor_cost = VendorCost::with(['vendor','customer','destination_provinces','origin_provinces'])->get();
 			return Datatables::of($vendor_cost)
      ->editColumn('vendor', function ($vendor_cost) {
        return $vendor_cost->vendor? with($vendor_cost->vendor->name) : '';
      })
      ->editColumn('customer', function ($vendor_cost) {
        return $vendor_cost->customer? with($vendor_cost->customer->name) : '';
      })
      ->editColumn('origin_provinces', function ($vendor_cost) {
        return $vendor_cost->origin_provinces? with($vendor_cost->origin_provinces->name) : '';
      })
      ->editColumn('destination_provinces', function ($vendor_cost) {
        return $vendor_cost->destination_provinces? with($vendor_cost->destination_provinces->name) : '';
      })
      ->editColumn('cost', function ($vendor_cost) {
        return $vendor_cost->cost? with("Rp " . number_format($vendor_cost->cost,0,',','.')) : '';
      })
      ->make(true);
 		} else {
      return abort(404);
 		}
 	}

 	public function create() {
    $vendor   = Vendor::all()->pluck('name','id')->toArray();
    $customer = Customer::all()->pluck('name','id')->toArray();
    $province = Indonesia::allProvinces()->pluck('name','id')->toArray();
    return view('cost/vendorcost/modal_add', compact('province', 'vendor', 'customer'));
 	}

  public function store(Request $request) {
    $this->validate($request, [
      'vendor'            => 'required',
      'customer'          => 'required',
      'org_provinces'     => 'required',
      'dest_provinces'    => 'required',
      'type'              => 'required'
    ]);

    $cost                                  = str_replace(".", "", $request->input('cost'));
    $vendorcost                            = new VendorCost();
    $vendorcost->vendor_id                 = $request->input('vendor');
    $vendorcost->customer_id               = $request->input('customer');
    $vendorcost->origin_provinces_id       = $request->input('org_provinces');
    $vendorcost->destination_provinces_id  = $request->input('dest_provinces');
    $vendorcost->type                      = $request->input('type');
    $vendorcost->cost                      = $cost;
    $vendorcost->created_by                = Auth::user()->id;
    $vendorcost->save();

    return response()->json(['responseText' => 'Success'], 200);
  }

  public function edit($id) {
    $vendorcost           = VendorCost::find($id);
    $province             = Indonesia::allProvinces()->pluck('name','id');
    $vendor               = Vendor::all()->pluck('name','id');
    $vendor_data          = $vendorcost->vendor_id;
    $customer             = Customer::all()->pluck('name','id');
    $customer_data        = $vendorcost->customer_id;
    $org_provinces        = $vendorcost->origin_provinces_id;
    $dest_provinces       = $vendorcost->destination_provinces_id;
    $province             = Indonesia::allProvinces()->pluck('name','id');

    return view(
      'cost/vendorcost/modal_edit',
        compact(
          'vendorcost', 
          'vendor', 
          'vendor_data', 
          'customer',
          'customer_data',
          'org_provinces',                                             
          'dest_provinces',
          'province'                                               
        )
    );
  }

  public function update(Request $request, $id) {

    $this->validate($request, [
      'vendor'            => 'required',
      'customer'          => 'required',
      'org_provinces'     => 'required',
      'dest_provinces'    => 'required',
      'type'              => 'required'
    ]);

    $cost                                  = str_replace(".", "", $request->input('cost'));
    $vendorcost                            = VendorCost::find($id);
    $vendorcost->vendor_id                 = $request->input('vendor');
    $vendorcost->customer_id               = $request->input('customer');
    $vendorcost->origin_provinces_id       = $request->input('org_provinces');
    $vendorcost->destination_provinces_id  = $request->input('dest_provinces');
    $vendorcost->type                      = $request->input('type');
    $vendorcost->cost                      = $cost;
    $vendorcost->updated_by                = Auth::user()->id;
    $vendorcost->save();

    return response()->json(['responseText' => 'Updated'], 200);
  }

  public function destroy($id) {
    $delete_vendorcost = Customer::find($id);
    $delete_vendorcost->deleted_by = Auth::user()->id;
    $delete_vendorcost->save();
    $delete_vendorcost->delete();
    return response()->json(['responseText' => 'Deleted'], 200);
  }
}
