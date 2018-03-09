<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipping;
use App\Termin;
use Response;
use Carbon\Carbon;
//use Chartjs;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $shipping_termin  = Shipping::where('payment_type', 'installment')->get();
        $shipping_pending = Shipping::where('status', 'Pending')->count();
        $total_income     = "Rp. ".number_format(Shipping::sum('cost'),0,',','.');
        $termin_total     = Termin::sum('payment');
        $term_dept        = 'Rp.'.number_format($shipping_termin->sum('cost') - $termin_total,0,',','.');
        $termin_due_date  = $this->termin_due_date();
        $do_due_date      = $this->do_due_date();

        $months = [1,2,3,4,5,6,7,8,9,10,11,12];
        $year = date('Y');

        foreach ($months as $month) {
          $taxs = Shipping::whereYear('created_at',$year)->whereMonth('created_at', $month)->sum('tax_cost');
          $tax[] = $taxs;

          $opcost = Shipping::whereYear('created_at',$year)->whereMonth('created_at', $month)->sum('operational_cost');
          $opscost[] = $opcost;

          $earnings_vendor = Shipping::where('shipping_method','=', 'vendor')
              ->where('payment_type','=','pay_off')
              ->whereYear('created_at',$year)
              ->whereMonth('created_at', $month)
              ->sum('vendor_cost');
          $earnings_default = Shipping::where('shipping_method','=', 'default')
              ->where('payment_type','=','pay_off')->whereYear('created_at',$year)
              ->whereMonth('created_at', $month)
              ->sum('default_cost');
          $termin = Termin::whereYear('payment_date',$year)->whereMonth('payment_date', $month)->sum('payment');
          $income[] = $earnings_vendor + $earnings_default + $termin;
        }

        $chartjs = app()->chartjs
        ->name('jujurperkasaChart')
        ->type('line')
        ->size(['width' => 450, 'height' => 200])
        ->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'])
        ->datasets([
            [
                "label" => "Income",
                'backgroundColor' => "rgba(0, 0, 0, 0)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "rgba(13, 6, 11, 0.58)",
                "pointHoverBorderColor" => "rgba(13, 6, 11, 0.58)",
                'data' => $income,
            ],
            [
                "label" => "Ops. Cost",
                'backgroundColor' => "rgba(0, 0, 0, 0)",
                'borderColor' => "rgba(188, 40, 79, 0.87)",
                "pointBorderColor" => "rgba(188, 40, 79, 0.87)",
                "pointBackgroundColor" => "rgba(188, 40, 79, 0.87)",
                "pointHoverBackgroundColor" => "rgba(13, 6, 11, 0.58)",
                "pointHoverBorderColor" => "rgba(13, 6, 11, 0.58)",
                'data' => $opscost,
            ],
            [
                "label" => "Tax",
                'backgroundColor' => "rgba(0, 0, 0, 0)",
                'borderColor' => "rgba(66, 108, 217, 1)",
                "pointBorderColor" => "rgba(66, 108, 217, 1)",
                "pointBackgroundColor" => "rgba(66, 108, 217, 1)",
                "pointHoverBackgroundColor" => "rgba(66, 108, 217, 1)",
                "pointHoverBorderColor" => "rgba(13, 6, 11, 0.58)",
                'data' => $tax,
            ]
        ])
            ->optionsRaw("{
              tooltips: {
                callbacks: {
                  label: function (tooltipItem, data) {
                    console.log(tooltipItem);
                    console.log( data.datasets[0])
                    return data.datasets[tooltipItem.datasetIndex].label + ' - ' +  Number(tooltipItem.yLabel).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, \",\");
                  },
                },
              },
              scales: {
                  yAxes: [{
                    ticks: {
                      
                      callback: function(value, index, values) {
                        return Number(value).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, \",\");
                      }
                    }
                  }]
                }
            }");
        return view('home', compact('shipping_pending', 'total_income','chartjs', 'term_dept', 'termin_due_date','do_due_date'));
        //return Response::json($due_date);
    }

    public function termin_due_date() {
      $shipping_termin = Shipping::where('payment_type', 'installment')->get();
      $date = [];
      $due_date = [];
      foreach ($shipping_termin as $dates) {
        $date[] = date('Y-m-d', strtotime('+'.$dates->time_period.'days', strtotime($dates->created_at)));
      }
      foreach ($date as $due_dates) {
        if ($due_dates <= Carbon::now()) {
          $due_date[] = $due_dates;
        } else {
          $due_date = [];
        }

      }
      $due_date  = count($due_date);
      return $due_date;
    }

    public function do_due_date(){
      $shipping_do = Shipping::where('do_out_time_period','>','0')
          ->where('shipping_method', 'default')
          ->where('do_out_status','0')
          ->whereNotNull('load_date')
          ->get();
      $date=[];
      foreach ($shipping_do as $dates) {
        $date[]=date('Y-m-d', strtotime('+'.$dates->do_out_time_period.'days', strtotime($dates->load_date)));
      }
      foreach ($date as $due_dates) {
        if ($due_dates <= Carbon::now()) {
          $due_date[] = $due_dates;
        } else {
          $due_date = [];
        }
      }
      $do_due_date  = count($due_date);
      return $do_due_date;
    }
}
