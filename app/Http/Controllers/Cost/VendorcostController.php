<?php

namespace App\Http\Controllers\Cost;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\VendorCost;
use App\Vendor;
use App\Customer;
use Auth;
use Datatables;
use Indonesia;
use Response;

class VendorcostController extends Controller {

  /**
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function index() {
		return view('cost/vendorcost/index');
	}

  /**
   * @param Request $request
   * @throws \Exception
   */
  public function getVendorcost(Request $request) {
 		if($request->ajax()){
      $vendor_cost = VendorCost::with(['vendor','customer','destination_provinces','destination_city', 'origin_provinces', 'origin_city'])->get();
 			return Datatables::of($vendor_cost)
      ->editColumn('vendor', function ($vendor_cost) {
        return $vendor_cost->vendor? with($vendor_cost->vendor->name) : '';
      })
      ->editColumn('customer', function ($vendor_cost) {
        return $vendor_cost->customer? with($vendor_cost->customer->name) : '';
      })
      ->editColumn('origin_city', function ($vendor_cost) {
        return $vendor_cost->origin_city? with($vendor_cost->origin_city->name.', '.$vendor_cost->origin_provinces->name) : '';
      })
      ->editColumn('destination_city', function ($vendor_cost) {
        return $vendor_cost->destination_city? with($vendor_cost->destination_city->name.', '.$vendor_cost->destination_provinces->name) : '';
      })
      ->editColumn('cost', function ($vendor_cost) {
        return $vendor_cost->cost? with("Rp " . number_format($vendor_cost->cost,0,',','.')) : '';
      })
      ->make(true);
 		} else {
      return abort(404);
 		}
 	}

  /**
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function create() {
    $vendor   = Vendor::all()->pluck('name','id')->toArray();
    $customer = Customer::all()->pluck('name','id')->toArray();
    $province = Indonesia::allProvinces()->pluck('name','id')->toArray();
    return view('cost/vendorcost/modal_add', compact('province', 'vendor', 'customer'));
 	}

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(Request $request) {

   $validator = Validator::make($request->all(), [
      'vendor'            => 'required',
      'customer'          => 'required',
      'org_provinces'     => 'required',
      'org_city'          => 'required',
      'dest_provinces'    => 'required',
      'dest_city'         => 'required',
      'type'              => 'required',
      'cost'              => 'required'
    ]);

   if ($validator->passes()) {
      $cost                                  = str_replace(".", "", $request->input('cost'));
      $vendorcost                            = new VendorCost();
      $vendorcost->vendor_id                 = $request->input('vendor');
      $vendorcost->customer_id               = $request->input('customer');
      $vendorcost->origin_provinces_id       = $request->input('org_provinces');
      $vendorcost->origin_city_id            = $request->input('org_city');
      $vendorcost->destination_provinces_id  = $request->input('dest_provinces');
      $vendorcost->destination_city_id       = $request->input('dest_city');
      $vendorcost->type                      = $request->input('type');
      $vendorcost->cost                      = $cost;
      $vendorcost->created_by                = Auth::user()->id;
      $vendorcost->save();
      return Response::json(['success' => 'added'], 200);
    }

    return Response::json(['errors' => $validator->errors()]);
  }

  /**
   * @param $id
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function edit($id) {
    $vendorcost           = VendorCost::find($id);
    $province             = Indonesia::allProvinces()->pluck('name','id');
    $vendor               = Vendor::all()->pluck('name','id');
    $vendor_data          = $vendorcost->vendor_id;
    $customer             = Customer::all()->pluck('name','id');
    $customer_data        = $vendorcost->customer_id;
    $org_provinces        = $vendorcost->origin_provinces_id;
    $org_city             = $vendorcost->origin_city_id;
    $city_org             = Indonesia::findProvince($org_provinces, ['cities']);
    $city_org             = null === $city_org ? [] : $city_org->cities->pluck('name', 'id')->toArray();
    $dest_provinces       = $vendorcost->destination_provinces_id;
    $dest_city            = $vendorcost->destination_city_id;
    $city_dest            = Indonesia::findProvince($dest_provinces, ['cities']);
    $city_dest            = null === $city_dest ? [] : $city_dest->cities->pluck('name', 'id')->toArray();

    return view(
      'cost/vendorcost/modal_edit',
        compact(
          'vendorcost', 
          'vendor', 
          'vendor_data', 
          'customer',
          'customer_data',
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

  /**
   * @param Request $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(Request $request, $id) {

    $validator = Validator::make($request->all(), [
      'vendor'            => 'required',
      'customer'          => 'required',
      'org_provinces'     => 'required',
      'org_city'          => 'required',
      'dest_provinces'    => 'required',
      'dest_city'         => 'required',
      'type'              => 'required'
    ]);

    if ($validator->passes()) {
      $cost                                  = str_replace(".", "", $request->input('cost'));
      $vendorcost                            = VendorCost::find($id);
      $vendorcost->vendor_id                 = $request->input('vendor');
      $vendorcost->customer_id               = $request->input('customer');
      $vendorcost->origin_provinces_id       = $request->input('org_provinces');
      $vendorcost->origin_city_id            = $request->input('org_city');
      $vendorcost->destination_provinces_id  = $request->input('dest_provinces');
      $vendorcost->destination_city_id       = $request->input('dest_city');
      $vendorcost->type                      = $request->input('type');
      $vendorcost->cost                      = $cost;
      $vendorcost->updated_by                = Auth::user()->id;
      $vendorcost->save();
      return Response::json(['success' => 'Updated'], 200);
    }
    return Response::json(['errors' => $validator->errors()]);
  }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id) {
    VendorCost::find($id)->delete();
    return Response::json(['responseText' => 'Deleted'], 200);
  }
}
