<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vehicle;
use App\Employees;
use Auth;
use DB;
use Datatables;
use Carbon\Carbon;

class VehicleController extends Controller {

  public function rules() {

  }
  
	public function index() {
		return view('master/vehicle/index');
	}

 	public function getVehicle(Request $request) {
 		if($request->ajax()) {
      $vehicle = Vehicle::with('employees')->get();
 			return Datatables::of($vehicle)
      ->editColumn('employees', function ($vehicle) {
        return $vehicle->employees? with($vehicle->employees->name) : '';
      })
      ->editColumn('created_at', function ($vehicle) {
        return $vehicle->created_at ? with(new Carbon($vehicle->created_at))->format('d M Y') : '';
      })
      ->editColumn('updated_at', function ($vehicle) {
          return $vehicle->updated_at ? with(new Carbon($vehicle->updated_at))->format('d M Y') : '';;
      })
      ->editColumn('vehicle_tax', function ($vehicle) {
          return $vehicle->vehicle_tax ? with(new Carbon($vehicle->vehicle_tax))->format('d M Y') : '';;
      })
      ->filterColumn('created_at', function ($query, $keyword) {
          $query->whereRaw("DATE_FORMAT(created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
      })
      ->filterColumn('updated_at', function ($query, $keyword) {
          $query->whereRaw("DATE_FORMAT(updated_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
      })
      ->filterColumn('vehicle_tax', function ($query, $keyword) {
          $query->whereRaw("DATE_FORMAT(vehicle_tax,'%m/%d/%Y') like ?", ["%$keyword%"]);
      })
      ->make(true);
 		} else {
 			return abort(404);
 		}
 	}

 	public function create() {
    $employees = Employees::pluck('name','id')->toArray();
    return view('master/vehicle/modal_add', compact('employees'));
 	}

  public function store(Request $request) {
    $this->validate($request, [
      'name'            => 'required',
      'plat_number'     => 'required',
      'driver'          => 'required',
      'type'            => 'required',
      'merk'            => 'required',
      'color'           => 'required',
      'production_year' => 'required',
      'vehicle_tax'     => 'required',
      'status'          => 'required',
    ]);

    $tax                        = Carbon::parse($request->input('vehicle_tax'));
    $vehicle                    = new Vehicle();
    $vehicle->name              = $request->input('name');
    $vehicle->plat_number       = $request->input('plat_number');
    $vehicle->employees_id      = $request->input('driver');
    $vehicle->type              = $request->input('type');
    $vehicle->merk              = $request->input('merk');
    $vehicle->color             = $request->input('color');
    $vehicle->production_year   = $request->input('production_year');
    $vehicle->vehicle_tax       = $tax;
    $vehicle->status            = $request->input('status');
    $vehicle->created_by        = Auth::user()->id;
    $vehicle->save();

    return response()->json(['responseText' => 'Success'], 200);
  }

  public function edit($id) {
    $vehicle            = Vehicle::find($id);
    $employees          = employees::all()->pluck('name','id')->toArray();
    $vehicle_employees  = $vehicle->employees_id;
    $vehicle_tax        = new Carbon($vehicle->vehicle_tax);
    $vehicle_tax        = $vehicle_tax->format('d-m-Y');
    return view('master/vehicle/modal_edit',
      compact(
        'vehicle', 
        'vehicle_tax',
        'employees',
        'vehicle_employees'
      )
    );
  }

  public function update(Request $request, $id) {    
    
    $vehicle = Vehicle::find($id);
    
    $this->validate($request, [
      'name'            => 'required',
      'plat_number'     => 'required',
      'driver'          => 'required',
      'type'            => 'required',
      'merk'            => 'required',
      'color'           => 'required',
      'production_year' => 'required',
      'vehicle_tax'     => 'required',
      'status'          => 'required',
    ]);

    $tax                        = Carbon::parse($request->input('vehicle_tax'));
    $vehicle->name              = $request->input('name');
    $vehicle->plat_number       = $request->input('plat_number');
    $vehicle->employees_id      = $request->input('driver');
    $vehicle->type              = $request->input('type');
    $vehicle->merk              = $request->input('merk');
    $vehicle->color             = $request->input('color');
    $vehicle->production_year   = $request->input('production_year');
    $vehicle->vehicle_tax       = $tax;
    $vehicle->status            = $request->input('status');
    $vehicle->updated_by        = Auth::user()->id;
    $vehicle->save();

    return response()->json(['responseText' => 'Updated'], 200);
  }

  public function destroy($id) {
    $delete_vehicle = Customer::find($id);
    $delete_vehicle->deleted_by = Auth::user()->id;
    $delete_vehicle->save();
    $delete_vehicle->delete();
    return response()->json(['responseText' => 'Deleted'], 200);
  }
}
