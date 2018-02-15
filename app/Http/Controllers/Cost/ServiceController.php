<?php

namespace App\Http\Controllers\Cost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use Auth;
use app\Customer;
use Datatables;
use Carbon\Carbon;

class ServiceController extends Controller {

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('cost/service/index');
	}

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function getService(Request $request) {
 		if($request->ajax()) {
      $service = Service::all();
 			return Datatables::of($service)
      ->editColumn('created_at', function ($service) {
        return $service->created_at ? with(new Carbon($service->created_at))->format('d M Y') : '';
      })
      ->editColumn('updated_at', function ($service) {
          return $service->updated_at ? with(new Carbon($service->updated_at))->format('d M Y') : '';;
      })
      ->filterColumn('created_at', function ($query, $keyword) {
          $query->whereRaw("DATE_FORMAT(created_at,'%m/%d/%Y') like ?", ["%$keyword%"]);
      })
      ->filterColumn('updated_at', function ($query, $keyword) {
          $query->whereRaw("DATE_FORMAT(updated_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
      })
      ->editColumn('unit_price', function ($service) {
        return $service->unit_price? with("Rp " . number_format($service->unit_price,0,',','.')) : '';
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
        return view('cost/service/modal_add');
 	}

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
    $this->validate($request, [
      'type_service'  => 'required|unique:service,type_service',
      'unit'          => 'required',
      'unit_price'    => 'required',
    ]);
    $unit_price             = str_replace(".", "", $request->input('unit_price'));
    $service                = new Service();
    $service->type_service  = $request->input('type_service');
    $service->unit          = $request->input('unit');
    $service->unit_price    = $unit_price;
    $service->created_by    = Auth::user()->id;
    $service->save();
    return response()->json(['responseText' => 'Success'], 200);
  }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
    $service = Service::find($id);
    return view('cost/service/modal_edit',compact('service'));
  }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
    $service = Service::find($id);
    $this->validate($request, [
      'type_service'  => 'required|unique:service,type_service,'.$service->id,
      'unit'          => 'required',
      'unit_price'    => 'required',
    ]);
    $unit_price               = str_replace(".", "", $request->input('unit_price'));
    $service->type_service    = $request->input('type_service');
    $service->unit            = $request->input('unit');
    $service->unit_price      = $unit_price;
    $service->updated_by      = Auth::user()->id;
    $service->save();
    return response()->json(['responseText' => 'Updated'], 200);
  }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id) {
    $delete_service               = Customer::find($id);
    $delete_service->deleted_by   = Auth::user()->id;
    $delete_service->save();
    $delete_service->delete();
    return response()->json(['responseText' => 'Deleted'], 200);
  }
}
