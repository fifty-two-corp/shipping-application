<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipping;
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
        $shipping_pending = Shipping::where('status', 'Pending')->count();
        $total_income = "Rp. ".number_format(Shipping::sum('cost'),0,',','.');
        $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
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
                'data' => [65, 59, 80, 81, 56, 55, 40],
            ],
            [
                "label" => "My Second dataset",
                'backgroundColor' => "rgba(0, 0, 0, 0)",
                'borderColor' => "rgba(188, 40, 79, 0.87)",
                "pointBorderColor" => "rgba(188, 40, 79, 0.87)",
                "pointBackgroundColor" => "rgba(188, 40, 79, 0.87)",
                "pointHoverBackgroundColor" => "rgba(13, 6, 11, 0.58)",
                "pointHoverBorderColor" => "rgba(13, 6, 11, 0.58)",
                'data' => [12, 33, 44, 44, 55, 23, 40],
            ]
        ])
        ->options([]);
        return view('home', compact('shipping_pending', 'total_income','chartjs'));
    }
}
