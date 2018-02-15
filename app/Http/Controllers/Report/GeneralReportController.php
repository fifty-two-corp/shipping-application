<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shipping;
use App\Termin;
use Auth;
use PDF;
use Response;
use Carbon\Carbon;

class GeneralReportController extends Controller {

    public function index() {
      return view('report/general-report/index');
    }

    public function ReportData (Request $request) {
      $date_start     = Carbon::parse($request->date_start)->format('Y-m-d');
      $date_end       = Carbon::parse($request->date_end)->addDays(1)->format('Y-m-d');
      $date_ends       = Carbon::parse($request->date_end)->format('Y-m-d');
//      $date_start = '2017-10-01';
//      $date_end   = '2018-03-01';
      $date_range = Carbon::parse($request->date_start)->format('d/m/Y')." - ".Carbon::parse($request->date_end)->format('d/m/Y');

      $transaction  = Shipping::with(['termin' => function ($query) use ($date_start, $date_end){
        $query->whereBetween('payment_date',[$date_start, $date_end]);
      }])->with('shipping_customer', 'shipping_destination')->whereBetween('created_at',[$date_start, $date_end])->get();

      $payoff_total = $this->get_pay_off_total($date_start, $date_end);

      $termin_total = $transaction->sum(function ($transaction) {
        return $transaction->termin->sum('payment');
      });
      $income_total = $payoff_total + $termin_total;
      $tax_total = $transaction->sum('tax_cost');
      $opcost_total = $transaction->sum('operational_cost');

      //return Response::json($transaction);
      return view('report/general-report/result',
          compact('transaction','income_total', 'tax_total', 'opcost_total', 'date_range', 'date_start', 'date_ends'));
    }

    public function get_pay_off_total($date_start, $date_end) {

      $transaction  = Shipping::with(['termin' => function ($query) use ($date_start, $date_end){
        $query->whereBetween('payment_date',[$date_start, $date_end]);
      }])->whereBetween('created_at',[$date_start, $date_end])->get();

      $filtered = $transaction->filter(function ($transaction, $key) {
        return $transaction->payment_type == 'pay_off';
      });

      $vendor_total = $filtered->sum('vendor_cost');
      $default_total = $filtered->sum('default_cost');
      $payoff_total = $vendor_total + $default_total;

      return $payoff_total;

    }

    public function general_report_pdf($date_start, $date_end) {
      $headers = ['Content-Type'=> 'application/pdf'];
      $date_range = Carbon::parse($date_start)->format('d/m/Y')." - ".Carbon::parse($date_end)->format('d/m/Y');

      $transaction  = Shipping::with(['termin' => function ($query) use ($date_start, $date_end){
        $query->whereBetween('payment_date',[$date_start, $date_end]);
      }])->with('shipping_customer', 'shipping_destination')->whereBetween('created_at',[$date_start, $date_end])->get();

      $payoff_total = $this->get_pay_off_total($date_start, $date_end);

      $termin_total = $transaction->sum(function ($transaction) {
        return $transaction->termin->sum('payment');
      });
      $income_total = $payoff_total + $termin_total;
      $tax_total = $transaction->sum('tax_cost');
      $opcost_total = $transaction->sum('operational_cost');

      $pdf = PDF::loadView('report/general-report/generalReportPDF',compact('transaction','income_total', 'tax_total', 'opcost_total', 'date_range'))
          ->setPaper('A4')
          ->setOption('footer-left', 'Page [page] of [toPage]')
          ->setOption('footer-right', 'printed by '.Auth::user()->name.'@'.Carbon::now()->format('d/m/Y H:i:s'))
          ->setOption('footer-font-size', 8);
      return $pdf->stream('general_report.pdf', $headers);

    }

}
