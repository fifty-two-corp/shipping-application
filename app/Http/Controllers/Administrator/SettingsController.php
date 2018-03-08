<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Settings;
use App\User;
use Auth;
use Datatables;
use Indonesia;
use Response;

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
    $users              = User::pluck('name', 'id')->toArray();
    $user_id            = $customer->user_id;
    return view('master/customer/modal_edit',
      compact(
        'customer', 
        'province', 
        'customer_province', 
        'city_customer', 
        'city',
        'district_customer',
        'districts',
        'users',
        'user_id'
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
    $customer->user_id          = $request->users;
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
