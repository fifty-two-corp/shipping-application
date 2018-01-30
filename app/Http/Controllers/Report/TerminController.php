<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\VendorCost;
use App\Vendor;
use App\Provinces;
use App\Customer;
use App\CustomerCost;
use App\Shipping;
use App\LoadList;
use App\Vehicle;
use App\ShippingVendor;
use App\ShippingCustomer;
use App\ShippingDestination;
use App\ShippingVehicle;
use App\Termin;
use Indonesia;
use Auth;
use DB;
use PDF;
use Validator;
use Response;
use Carbon\Carbon;
use Datatables;

class TerminController extends Controller {
    
    public function index() {
      return view('report/termin/index-list');
    }

    public function getTerminList(Request $request){
      if($request->ajax()){
        $termin_list = Shipping::with('shipping_vendor', 'shipping_customer', 'shipping_destination', 'shipping_vehicle', 'termin')->whereNotNull('time_period')->get();
        return Datatables::of($termin_list)
        ->addColumn('termin_customer_name', function ($termin_list) {
          return $termin_list->shipping_customer? with($termin_list->shipping_customer->customer_name) : '';
        })
        ->editColumn('cost', function ($termin_list) {
          return $termin_list->cost? with("Rp. " . number_format($termin_list->cost,0,',','.')) : '';
        })
        ->editColumn('time_period', function ($termin_list) {
          return $termin_list->time_period? with($termin_list->time_period.' days') : '';
        })
        ->addColumn('due_date', function($termin_list) {
          $due_datess = date('Y-m-d', strtotime('+'.$termin_list->time_period.'days', strtotime($termin_list->created_at)));
          $due_dates = Carbon::parse($due_datess)->toFormattedDateString();
          if ($termin_list->cost - $termin_list->termin->sum('payment') <= '0') {
            $due_date = "<p class='text-success'>".$due_dates."</p>" ;
          } elseif (Carbon::now()->diffInDays(Carbon::parse($due_datess)) <= '0') {
            $due_date = "<p class='text-danger'>".$due_dates."</p>" ;
          } elseif (Carbon::now()->diffInDays(Carbon::parse($due_datess)) >= '-7' && Carbon::now()->diffInDays(Carbon::parse($due_datess)) <= '7') {
            $due_date = "<p class='text-warning'>".$due_dates."</p>" ;
          } else {
            $due_date = "<p class='text-primary'>".$due_dates."</p>" ;
          }
          return $due_date;
        })
        ->addColumn('payment', function($termin_list) {
          return $termin_list->termin->sum('payment')? with("Rp. " . number_format($termin_list->termin->sum('payment'),0,',','.')) : '';
        })
        ->addColumn('remaining_payment', function($termin_list) {
          $remaining_payment = $termin_list->cost-$termin_list->termin->sum('payment');
          if ($remaining_payment == '0') {
            $remaining_payment = "<p class='text-success'>"."Rp. " . number_format($remaining_payment,0,',','.')."</p>" ;
          } elseif ($remaining_payment < '0') {
            $remaining_payment = "<p class='text-danger'>"."Rp. " . number_format($remaining_payment,0,',','.')."</p>" ;
          } else {
            $remaining_payment = "<p class='text-primary'>"."Rp. " . number_format($remaining_payment,0,',','.')."</p>" ;
          }
          return $remaining_payment;
        })
        ->rawColumns(['due_date', 'remaining_payment'])
        ->make(true);
      } else {
        return abort(404);
      }
    }

    public function getTerminDetails($id) {
      $data = Shipping::with('load_list','shipping_vendor', 'shipping_customer', 'shipping_destination', 'shipping_vehicle', 'termin')->find($id);
      $date = Carbon::parse($data->created_at)->toFormattedDateString();
      $due_date = date('Y-m-d', strtotime('+'.$data->time_period.'days', strtotime($data->created_at)));
      $due_date = Carbon::parse($due_date)->toFormattedDateString();
      $i = 1;
      return view('report/termin/termin_details', compact('data', 'date', 'due_date', 'i'));
    }

    public function edit($id) {
      return view('report/termin/modal_add_payment');
    }

    public function update(Request $request, $id) {
      
      $this->validate($request, [
        'payment_date'   => 'required',
        'payment'        => 'required'
      ]);
      $payment_date         = Carbon::parse($request->input('payment_date'));
      $payment              = str_replace(".", "", $request->input('payment'));
      $shipping             = Shipping::find($id);
      $termin               = new Termin;
      $termin->shipping_id  = $shipping->id;
      $termin->payment      = $payment;
      $termin->payment_date = $payment_date;
      $termin->created_by   = Auth::user()->name;
      $termin->save();

      return response()->json(['responseText' => 'Updated'], 200);
    }

    public function invoice($id) {
      $data = Shipping::with('load_list','shipping_vendor', 'shipping_customer', 'shipping_destination', 'shipping_vehicle')->find($id);
      $date = Carbon::parse($data->created_at)->toFormattedDateString();
      $due_date = date('Y-m-d', strtotime('+'.$data->termin.'days', strtotime($data->created_at)));
      $due_date = Carbon::parse($due_date)->toFormattedDateString();
      return view('transaction/invoice/index', compact('data', 'date', 'due_date'));
    }

    public function invoicePdf($id) {
      $headers = ['Content-Type'=> 'application/pdf'];
      $data = Shipping::with('load_list','shipping_vendor', 'shipping_customer', 'shipping_destination', 'shipping_vehicle')->find($id);
      $date = Carbon::parse($data->created_at)->toFormattedDateString();
      $due_date = date('Y-m-d', strtotime('+'.$data->termin.'days', strtotime($data->created_at)));
      $due_date = Carbon::parse($due_date)->toFormattedDateString();
      $pdf = PDF::loadView('transaction/invoice/index', compact('data', 'date', 'due_date'))
      ->setPaper('A4');
      return $pdf->download('invoice #('.$id.').pdf', $headers);
      //return view('transaction/invoice/invoice-pdf', compact('data', 'date'));
    }

    public function doPdf($id) {
      $headers = ['Content-Type'=> 'application/pdf'];
      $data = Shipping::with('load_list','shipping_vendor', 'shipping_customer', 'shipping_destination', 'shipping_vehicle')->find($id);
      $date = Carbon::parse($data->created_at)->toFormattedDateString();
      $due_date = date('Y-m-d', strtotime('+'.$data->termin.'days', strtotime($data->created_at)));
      $due_date = Carbon::parse($due_date)->toFormattedDateString();
      $pdf = PDF::loadView('transaction/invoice/index', compact('data', 'date', 'due_date'))
      ->setPaper('A4');
      //return $pdf->download('invoice.pdf', $headers);
      return view('transaction/do/index', compact('data', 'date', 'due_date'));
    }

    public function getInstallmentForm() {
      return view('transaction/shipping/installment_form');
    }

    public function ShippingList(){
      return view('transaction/shipping/index-list');
    }

    public function destroy($id) {
      $delete_customer = Shipping::find($id);
      $delete_customer->deleted_by = Auth::user()->id;
      $delete_customer->save();
      $delete_customer->delete();
      return response()->json(['responseText' => 'Deleted'], 200);
    }
}
