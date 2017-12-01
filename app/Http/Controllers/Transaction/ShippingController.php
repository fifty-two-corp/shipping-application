<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\VendorCost;
use App\Vendor;
use App\Provinces;
use App\Customer;
use App\CustomerCost;
use Indonesia;
use Auth;
use DB;

class ShippingController extends Controller {
    
    public function index() {
      $customer_list   = Customer::all()->pluck('name','id')->toArray();
      $provinces  = Indonesia::allProvinces()->pluck('name','id')->toArray();
      return view('transaction/shipping/index', 
        compact(
          'customer_list',
          'provinces'
        )
      );
    }

    public function getCustomerData($id) {
      $customer_data = Customer::where('id', $id)->get();
      return response()->json($customer_data);
    }

    public function getCustomerShippingType($id) {
      $shipping_type = CustomerCost::where('customer_id', $id)->pluck('type')->toArray();
      return response()->json($shipping_type);
    }

    public function getCustomerCost($id) {
      CustomerCost::with(['customer','destination_provinces','origin_provinces'])->where('customer_id', $id)->get();
    }

    public function getVendorCost($id) {
      VendorCost::with(['vendor','customer','destination_provinces','origin_provinces'])->where('vendor_id', $id)->get();
    }

    public function getCalculateCost($origin, $destination, $customer_id) {
      $customer_cost = CustomerCost::with(['customer'])->where([
          ['customer_id','=', $customer_id],
          ['origin_provinces_id','=', $origin],
          ['destination_provinces_id','=', $destination]
        ])->first();
      $cost = $customer_cost->cost;
      $customer_discount = $customer_cost->customer->discount;
      $discount = $cost*$customer_discount/'100';
      $total = $cost - $discount;
      $shipping_cost = [
        'cost' => number_format($cost), 
        'customer_discount' => $customer_discount.'%', 
        'discount' => number_format($discount), 
        'total' => number_format($total)
      ];
      return response()->json($shipping_cost);
    }

    public function store(Request $request)
    {
        return response()->json($request);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
