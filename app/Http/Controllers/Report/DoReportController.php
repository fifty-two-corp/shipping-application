<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shipping;
use App\User;
use Carbon\Carbon;
use Auth;
use Datatables;
use Indonesia;
use Response;

class DoReportController extends Controller {
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
		return view('report/doreport/index');
	}

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function getDO(Request $request) {
 		//if($request->ajax()){
      $do = Shipping::with('shipping_vendor', 'shipping_destination', 'shipping_vehicle', 'shipping_customer')
          ->where('do_out_time_period','>','0')
          ->where('shipping_method', 'default')
          ->whereNotNull('load_date')
          ->get();
        return Datatables::of($do)
            ->addColumn('shipping_customer_name', function ($do) {
              return $do->shipping_customer? with($do->shipping_customer->customer_name) : '';
            })
            ->editColumn('destination', function ($do) {
              return $do->shipping_destination? with($do->shipping_destination->consignee_city.', '.$do->shipping_destination->consignee_province) : '';
            })
            ->editColumn('load_date', function ($do) {
              //$load_date = date('Y-m-d ', strtotime($do->load_date.' days'));
              return $do->load_date? with(Carbon::parse($do->load_date)->toFormattedDateString()) : '';
            })
            ->editColumn('do_out_time_period', function ($do) {
              return $do->do_out_time_period? with($do->do_out_time_period.' days') : '';
            })
            ->addColumn('driver', function($do) {
              return $do->shipping_vehicle? with($do->shipping_vehicle->vehicle_driver) : '-';
            })
            ->addColumn('due_date', function($do) {
              $due_datess = date('Y-m-d H:i:s', strtotime('+'.$do->do_out_time_period.'days', strtotime($do->load_date)));
              $due_dates = Carbon::parse($due_datess)->toFormattedDateString();
              if ($do->do_out_status == 1) {
                $due_date = '-';
              }elseif (Carbon::now()->diffInDays(Carbon::parse($due_datess),false) <= '0') {
                $due_date = "<p class='text-danger'>".$due_dates."</p>" ;
              } elseif (Carbon::now()->diffInDays(Carbon::parse($due_datess), false) <= '7') {
                $due_date = "<p class='text-warning'>".$due_dates."</p>" ;
              } else {
                $due_date = "<p class='text-primary'>".$due_dates."</p>" ;
              }
              return $due_date;
            })
            ->rawColumns(['due_date'])
          ->make(true);
 		//} else {
 			//return abort(404);
 		//}
 	}

    public function edit($id) {
    $do_out           = Shipping::find($id);
    $do_out_status    = $do_out->do_out_status;
    return view('report/doreport/modal_update',compact('do_out','do_out_status'));
  }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
    $shipping   = Shipping::find($id);

    $shipping->do_out_status  = $request->status;
    $shipping->updated_by       = Auth::user()->id;
    $shipping->save();
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
