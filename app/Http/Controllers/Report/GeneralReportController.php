<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shipping;
use App\Termin;
use Auth;
use PDF;
use Validator;
use Response;
use Carbon\Carbon;

class GeneralReportController extends Controller {
    
    public function index() {
      return view('report/general-report/index');
    }

    public function ReportData (Request $request) {
      $date_start     = Carbon::parse($request->date_start)->format('Y-m-d');
      $date_end       = Carbon::parse($request->date_end)->format('Y-m-d');
      $termin_data    = Termin::whereBetween('payment_date',[$date_start, $date_end])->get();
      $income_termin  = $termin_data->sum('payment');
      $payoff_data    = Shipping::whereBetween('created_at',[$date_start, $date_end])->whereNull('time_period')->get();
      $income_payoff  = $payoff_data->sum('cost');
      $income_total   = $income_termin + $income_payoff;
      
      return view('report/general-report/result', compact('termin_data'));
    }

}
