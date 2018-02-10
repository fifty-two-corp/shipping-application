<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employees;
use App\Provinces;
use App\City;
use App\IdMethod;
use Auth;
use DB;
use Datatables;
use Indonesia;

class EmployeesController extends Controller {
  
	public function index() {
		return view('master/employees/index');
	}

 	public function getEmployees(Request $request) {
 		if($request->ajax()) {
      $employees = Employees::with('province', 'city', 'districts', 'identity_method')->get();
 			return Datatables::of($employees)
      ->editColumn('identity_method', function ($employees) {
        return $employees->identity_method? with($employees->identity_method->name) : '';
      })
      ->editColumn('province', function ($employees) {
        return $employees->province? with($employees->province->name) : '';
      })
      ->editColumn('city', function ($employees) {
        return $employees->city? with($employees->city->name) : '';
      })
      ->editColumn('districts', function ($employees) {
        return $employees->districts? with($employees->districts->name) : '';
      })
      ->make(true);
 		} else {
 			return abort(404);
 		}
 	}

 	public function create() {
    $province = Indonesia::allProvinces()->pluck('name','id')->toArray();
    $identity_method = IdMethod::pluck('name','name')->toArray();
    return view('master/employees/modal_add', compact('province', 'identity_method'));
 	}

  public function store(Request $request) {
    $this->validate($request, [
      'employees_number'  => 'required|unique:employees,employees_number,NULL,id,deleted_at,NULL',
      'name'              => 'required',
      'address'           => 'required',
      'province'          => 'required',
      'city'              => 'required',
      'phone'             => 'required',
      'identity_method'   => 'required',
      'identity_number'   => 'required',
    ]);

    $employees                      = new Employees();
    $employees->employees_number    = $request->input('employees_number');
    $employees->name                = $request->input('name');
    $employees->address             = $request->input('address');
    $employees->province_id         = $request->input('province');
    $employees->city_id             = $request->input('city');
    $employees->districts_id        = $request->input('districts');
    $employees->phone               = $request->input('phone');
    $employees->identity_method_id  = $request->input('identity_method');
    $employees->identity_number     = $request->input('identity_number');
    $employees->created_by          = Auth::user()->id;
    $employees->save();

    return response()->json(['responseText' => 'Success'], 200);
  }

  public function edit($id) {
    $employees           = Employees::find($id);
    $province            = Indonesia::allProvinces()->pluck('name','id')->toArray();
    $identity_method     = IdMethod::all()->pluck('name','id')->toArray();
    $identity            = $employees->identity_method_id;
    $employees_province  = $employees->province_id;
    $city_employees      = $employees->city_id;
    $district_employees  = $employees->districts_id;
    $city                = Indonesia::findProvince($employees_province, ['cities']);
    $city                = null === $city ? [] : $city->cities->pluck('name', 'id')->toArray();
    $districts           = Indonesia::findCity($city_employees, ['districts']);
    $districts           = null === $districts ? [] : $districts->districts->pluck('name', 'id')->toArray();

    return view('master/employees/modal_edit',
      compact(
        'employees', 
        'province', 
        'identity_method', 
        'employees_province', 
        'city_employees', 
        'city', 
        'identity',
        'districts',
        'district_employees'
      )
    );
   }

  public function update(Request $request, $id) {
    
    $employees = Employees::with('province', 'city', 'districts', 'identity_method')->find($id);
    
    $this->validate($request, [
      'employees_number'  => 'required|unique:employees,employees_number,'.$employees->id.',id,deleted_at,NULL',
      'name'              => 'required',
      'address'           => 'required',
      'province'          => 'required',
      'city'              => 'required',
      'phone'             => 'required',
      'identity_method'   => 'required',
      'identity_number'   => 'required',
    ]);

    $employees->employees_number    = $request->input('employees_number');
    $employees->name                = $request->input('name');
    $employees->address             = $request->input('address');
    $employees->province_id         = $request->input('province');
    $employees->city_id             = $request->input('city');
    $employees->districts_id        = $request->input('districts');
    $employees->phone               = $request->input('phone');
    $employees->identity_method_id  = $request->input('identity_method');
    $employees->identity_number     = $request->input('identity_number');
    $employees->updated_by          = Auth::user()->id;
    $employees->save();

    return response()->json(['responseText' => 'Updated'], 200);
  }

  public function destroy($id) {
    Employees::find($id)->delete();
    return response()->json(['responseText' => 'Deleted'], 200);
  }
}
