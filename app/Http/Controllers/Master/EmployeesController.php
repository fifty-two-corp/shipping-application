<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employees;
use App\IdMethod;
use App\Vehicle;
use Auth;
use Datatables;
use Indonesia;
use Response;

class EmployeesController extends Controller {

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
		return view('master/employees/index');
	}

    /**
     * @param Request $request
     * @throws \Exception
     */
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
    $employees->employees_number    = $request->employees_number;
    $employees->name                = $request->name;
    $employees->address             = $request->address;
    $employees->province_id         = $request->province;
    $employees->city_id             = $request->city;
    $employees->districts_id        = $request->districts;
    $employees->phone               = $request->phone;
    $employees->identity_method_id  = $request->identity_method;
    $employees->identity_number     = $request->identity_number;
    $employees->created_by          = Auth::user()->id;
    $employees->save();

    return Response::json(['responseText' => 'Success'], 200);
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

    $employees->employees_number    = $request->employees_number;
    $employees->name                = $request->name;
    $employees->address             = $request->address;
    $employees->province_id         = $request->province;
    $employees->city_id             = $request->city;
    $employees->districts_id        = $request->districts;
    $employees->phone               = $request->phone;
    $employees->identity_method_id  = $request->identity_method;
    $employees->identity_number     = $request->identity_number;
    $employees->updated_by          = Auth::user()->id;
    $employees->save();

    return Response::json(['responseText' => 'Updated'], 200);
  }

  public function destroy($id) {
    Employees::find($id)->delete();
    return Response::json(['responseText' => 'Deleted'], 200);
  }
}
