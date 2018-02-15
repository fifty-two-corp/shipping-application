<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use Auth;
use Datatables;
use Indonesia;
use Response;

class CustomerController extends Controller {
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
		return view('master/customer/index');
	}

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function getCustomer(Request $request) {
 		if($request->ajax()){
          $customer = Customer::with('province', 'city', 'districts')->get();
            return Datatables::of($customer)
              ->editColumn('province', function ($customer) {
                return $customer->province? with($customer->province->name) : '-';
              })
              ->editColumn('city', function ($customer) {
                return $customer->city? with($customer->city->name) : '-';
              })
              ->editColumn('districts', function ($customer) {
                return $customer->districts? with($customer->districts->name) : '-';
              })
              ->editColumn('discount', function ($vendor_cost) {
                return $vendor_cost->discount? with($vendor_cost->discount.' %') : '-';
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
    $province = Indonesia::allProvinces()->pluck('name','id')->toArray();
    return view('master/customer/modal_add', compact('province'));
 	}

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
    $this->validate($request, [
      'customer_number'   => 'required|unique:customer,customer_number,NULL,id,deleted_at,NULL',
      'name'              => 'required',
      'address'           => 'required',
      'province'          => 'required',
      'city'              => 'required',
      'phone'             => 'required'
    ]);
    $customer = new Customer();
    $customer->customer_number  = $request->customer_number;
    $customer->name             = $request->name;
    $customer->address          = $request->address;
    $customer->province_id      = $request->province;
    $customer->city_id          = $request->city;
    $customer->districts_id     = $request->districts;
    $customer->phone            = $request->phone;
    $customer->npwp             = $request->npwp;
    $customer->discount         = $request->discount;
    $customer->created_by       = Auth::user()->id;
    $customer->save();
    return Response::json(['responseText' => 'Success'], 200);
  }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
    $customer           = Customer::find($id);
    $province           = Indonesia::allProvinces()->pluck('name','id')->toArray();
    $customer_province  = $customer->province_id;
    $city_customer      = $customer->city_id;
    $district_customer  = $customer->districts_id;
    $city               = Indonesia::findProvince($customer_province, ['cities']);
    $city               = null === $city ? [] : $city->cities->pluck('name', 'id')->toArray();
    $districts          = Indonesia::findCity($city_customer, ['districts']);
    $districts          = null === $districts ? [] : $districts->districts->pluck('name', 'id')->toArray();
    return view('master/customer/modal_edit',
      compact(
        'customer', 
        'province', 
        'customer_province', 
        'city_customer', 
        'city',
        'district_customer',
        'districts'
      )
    );
  }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
    $customer   = Customer::find($id);
    $this->validate($request, [
      'customer_number'   => 'required|unique:customer,customer_number,'.$customer->id.',id,deleted_at,NULL',
      'name'              => 'required',
      'address'           => 'required',
      'province'          => 'required',
      'city'              => 'required',
      'phone'             => 'required',
    ]);

    $customer->customer_number  = $request->customer_number;
    $customer->name             = $request->name;
    $customer->address          = $request->address;
    $customer->province_id      = $request->province;
    $customer->city_id          = $request->city;
    $customer->districts_id     = $request->districts;
    $customer->phone            = $request->phone;
    $customer->npwp             = $request->npwp;
    $customer->discount         = $request->discount;
    $customer->updated_by       = Auth::user()->id;
    $customer->save();

    return Response::json(['responseText' => 'Updated'], 200);
  }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id) {
    $delete_customer = Customer::find($id);
    $delete_customer->deleted_by = Auth::user()->id;
    $delete_customer->save();
    $delete_customer->delete();
    return Response::json(['responseText' => 'Deleted'], 200);
  }
}
