<?php

namespace App\Http\Controllers\Transaction;

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

class ShippingController extends Controller {
    
    public function index() {
      $customer_list   = Customer::all()->pluck('name','id')->toArray();
      $provinces  = Indonesia::allProvinces()->pluck('name','id')->toArray();
      return view('transaction/shipping/index', compact('customer_list','provinces'));
    }

    public function getCustomerData($id) {
      $customer_data = Customer::find($id);
      $customer_province = $customer_data->province;
      $customer_city = $customer_data->city;
      $customer_district = $customer_data->districts;
      return Response::json($customer_data);
    }

    public function getShippingMethodField() {
      return view('transaction/shipping/shipping-method-field');
    }

    public function getDefaultForm($customer, $destination) {
      $customer_shipping_type = CustomerCost::where('destination_city_id', $destination)->where('customer_id', $customer)
      ->pluck('type','id')->toArray();
      //$default = CustomerCost::where('destination_provinces_id', $destination)->pluck('type', 'id')->toArray();
      return view('transaction/shipping/default_form', compact('customer_shipping_type'));
    }

    public function getVendorForm($customer, $destination) {
      $vendor_cost = VendorCost::where('destination_city_id', $destination)->where('customer_id', $customer)->pluck('vendor_id');
      $vendor = Vendor::whereIn('id',$vendor_cost)->pluck('name','id')->toArray();
      return view('transaction/shipping/vendor_form', compact('vendor'));
    }

    public function getVendorData($id) {
      $vendor_data = Vendor::find($id);
      $vendor_province = $vendor_data->province;
      $vendor_city = $vendor_data->city;
      $vendor_district = $vendor_data->districts;
      return response()->json($vendor_data);
    }

    public function getVendorShippingType($customer, $destination, $vendor) {
      $vendor_shipping_type = VendorCost::where('destination_city_id', $destination)
      ->where('customer_id', $customer)
      ->where('vendor_id', $vendor)
      ->get();
      return response()->json($vendor_shipping_type);
    }

    public function getCustomerShippingType($id) {
      $shipping_type = CustomerCost::where('customer_id', $id)->pluck('type')->toArray();
      return response()->json($shipping_type);
    }

    public function getCustomerCost($id) {
      CustomerCost::with(['customer','destination_city','origin_city'])->where('customer_id', $id)->get();
    }

    public function getVendorCost($id) {
      VendorCost::with(['vendor','customer','destination_city','origin_city'])->where('vendor_id', $id)->get();
    }

    public function getCalculateDefaultCost($id) {
      $customer_cost = CustomerCost::where('id', $id)->first();
      $cost          = $customer_cost->cost;
      $customer_npwp = strlen($customer_cost->customer->npwp);
      $customer_npwp > 5 ? $tax = 2 : $tax = 4;
      $tax_cost      = $cost*$tax/100;
      $total_cost    = $cost+$tax_cost;
      $shipping_cost = [
        'cost'        => number_format($cost), 
        'tax'         => $tax.'%', 
        'tax_cost'    => number_format($tax_cost), 
        'total_cost'  => number_format($total_cost)
      ];
      return Response::json($shipping_cost);
    }

    public function getCalculateVendorCost($id) {
      $vendor_cost   = VendorCost::where('id', $id)->first();
      $cost          = $vendor_cost->cost;
      $customer_npwp = strlen($vendor_cost->customer->npwp);
      $customer_npwp > 5 ? $tax = 2 : $tax = 4;
      $tax_cost      = $cost*$tax/100;
      $total_cost    = $cost+$tax_cost;
      $shipping_cost = [
        'cost'        => number_format($cost), 
        'tax'         => $tax.'%', 
        'tax_cost'    => number_format($tax_cost), 
        'total_cost'  => number_format($total_cost)
      ];
      return Response::json($shipping_cost);
    }

    public function store(Request $request) {
      $shipping = new Shipping;
      if ($request->method === 'default') {
        $shipping_cost              = json_decode($this->getCalculateDefaultCost($request->shipping_type)->content(), true);
        $customer_cost_data         = CustomerCost::find($request->shipping_type);
        $shipping->default_type     = $customer_cost_data->type;
        $shipping->default_cost     = $customer_cost_data->cost;
      } elseif($request->method === 'vendor') {
        $shipping_cost              = json_decode($this->getCalculateVendorCost($request->shipping_type)->content(), true);
        $shipping_vendor_cost_data  = VendorCost::find($request->shipping_type);
        $shipping->vendor_cost      = $shipping_vendor_cost_data->cost;
        $shipping->vendor_type      = $shipping_vendor_cost_data->type;
      }
      if ($request->payment === 'installment') {
        $shipping->payment_type      = 'installment';
        $shipping->down_payment      = str_replace(".", "",$request->down_payment);
        $shipping->time_period       =  $request->time_period;
      } else {
        $shipping->payment_type      = 'pay_off';
      }

      $shipping->transaction_number    = 'JP-'.date('dmyHis');
      $shipping->tax_value             = str_replace('%', '', $shipping_cost['tax']);
      $shipping->tax_cost              = str_replace(',','',$shipping_cost['tax_cost']);
      $shipping->shipping_method       = $request->method;
      $shipping->cost                  = str_replace(',','',$shipping_cost['total_cost']);
      $shipping->created_by            = Auth::user()->name;
      $shipping->save();

      $shipping_customer_data               = Customer::with('province', 'city', 'districts')->find($request->customer);
      $shipping_customer                    = new ShippingCustomer;
      $shipping_customer->shipping_id       = $shipping->id;;
      $shipping_customer->customer_id       = $shipping_customer_data->id;
      $shipping_customer->customer_number   = $shipping_customer_data->customer_number;
      $shipping_customer->customer_name     = $shipping_customer_data->name;
      $shipping_customer->customer_address  = $shipping_customer_data->address;
      $shipping_customer->customer_province = ucwords(strtolower($shipping_customer_data->province->name));
      $shipping_customer->customer_city     = ucwords(strtolower($shipping_customer_data->city->name));
      $shipping_customer->customer_district = ucwords(strtolower($shipping_customer_data->districts->name));
      $shipping_customer->customer_phone    = $shipping_customer_data->phone;
      $shipping_customer->customer_npwp     = $shipping_customer_data->npwp;
      $shipping_customer->created_by        = Auth::user()->name;
      $shipping_customer->save();

      $shipping_destination                     = new ShippingDestination;
      $shipping_destination->shipping_id        = $shipping->id;
      $shipping_destination->consignee_name     = $request->consignee_name;
      $shipping_destination->consignee_address  = $request->consignee_address;
      $shipping_destination->consignee_province = Indonesia::findProvince($request->consignee_province, $with = null)->name;
      $shipping_destination->consignee_city     = Indonesia::findCity($request->consignee_city, $with = null)->name;
      $shipping_destination->consignee_district = Indonesia::findDistrict($request->consignee_district, $with = null)->name;
      $shipping_destination->consignee_phone    = $request->consignee_phone;
      $shipping_destination->created_by         = Auth::user()->name;
      $shipping_destination->save();

      if ($request->method === 'vendor') {
        $shipping_vendor_data              = Vendor::with('province', 'city', 'districts')->find($request->vendor);
        $shipping_vendor                   = new ShippingVendor;
        $shipping_vendor->shipping_id      = $shipping->id;
        $shipping_vendor->vendor_id        = $shipping_vendor_data->id;
        $shipping_vendor->vendor_number    = $shipping_vendor_data->vendor_number;
        $shipping_vendor->vendor_name      = $shipping_vendor_data->name;
        $shipping_vendor->vendor_address   = $shipping_vendor_data->address;
        $shipping_vendor->vendor_province  = ucwords(strtolower($shipping_vendor_data->province->name));
        $shipping_vendor->vendor_city      = ucwords(strtolower($shipping_vendor_data->city->name));
        $shipping_vendor->vendor_district  = ucwords(strtolower($shipping_vendor_data->districts->name));
        $shipping_vendor->vendor_phone     = $shipping_vendor_data->phone;
        $shipping_vendor->created_by       = Auth::user()->name;
        $shipping_vendor->save();
      }

      if ($request->payment === 'installment') {
        $date_now             = Carbon::now();
        $termin               = new Termin;
        $termin->shipping_id  = $shipping->id;
        $termin->payment      = str_replace(".", "",$request->down_payment);
        $termin->payment_date = $date_now->toDateTimeString();
        $termin->created_by   = Auth::user()->name;
        $termin->save();
      }

      foreach ($request->load_item as $key => $value) {
        $loadlist              = new LoadList;
        $loadlist->shipping_id = $shipping->id;
        $loadlist->item        = $request->load_item[$key];
        $loadlist->quantity    = $request->load_quantity[$key];
        $loadlist->dimension   = $request->load_dimension[$key];
        $loadlist->created_by  = Auth::user()->name;
        $loadlist->save();
      }

      return Response::json(['responseText' => 'Success', 'shipping_id' => $shipping->id], 200);
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
      $due_date = date('Y-m-d', strtotime('+'.$data->time_period.'days', strtotime($data->created_at)));
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
      $due_date = date('Y-m-d', strtotime('+'.$data->time_period.'days', strtotime($data->created_at)));
      $due_date = Carbon::parse($due_date)->toFormattedDateString();
      $pdf = PDF::loadView('transaction/invoice/index', compact('data', 'date', 'due_date'))
      ->setPaper('A4');
      //return $pdf->download('invoice.pdf', $headers);
      return view('transaction/do/index', compact('data', 'date', 'due_date'));
      //return Response::json($data);
    }

    public function getInstallmentForm() {
      return view('transaction/shipping/installment_form');
    }

    public function ShippingList(){
      return view('transaction/shipping/index-list');
    }

    public function getShippingList(Request $request){
      if($request->ajax()){
        $shipping_list = Shipping::with('shipping_vendor', 'shipping_customer', 'shipping_destination', 'shipping_vehicle')->get();
        
        return Datatables::of($shipping_list)
        ->addColumn('shipping_customer_name', function ($shipping_list) {
          return $shipping_list->shipping_customer? with($shipping_list->shipping_customer->customer_name) : '';
        })
        ->addColumn('consignee_name', function ($shipping_list) {
          return $shipping_list->shipping_destination? with($shipping_list->shipping_destination->consignee_name) : '';
        })
        ->editColumn('destination', function ($shipping_list) {
          return $shipping_list->shipping_destination? with($shipping_list->shipping_destination->consignee_city.', '.$shipping_list->shipping_destination->consignee_province) : '';
        })
        ->editColumn('cost', function ($shipping_list) {
          return $shipping_list->cost? with("Rp. " . number_format($shipping_list->cost,0,',','.')) : '';
        })
        ->editColumn('status', function ($shipping_list) {
          $status = $shipping_list->status;
          if ($status == 'Pending') {
            $status = "<span class='label label-warning'>".$status."</span>" ;
          } elseif ($status == 'On Process') {
            $status = "<span class='label label-primary'>".$status."</span>" ;
          } elseif ($status == 'Complete') {
            $status = "<span class='label label-success'>".$status."</span>" ;
          } elseif ($status =='Cancel') {
            $status = "<span class='label label-danger'>".$status."</span>" ;
          }
          return $shipping_list->status? with($status) : $tatus;
        })
        ->rawColumns(['status'])->make(true);
      } else {
        return abort(404);
      }
    }

    public function getShippingDetails($id) {
      $data = Shipping::with('load_list','shipping_vendor', 'shipping_customer', 'shipping_destination', 'shipping_vehicle')->find($id);
      $date = Carbon::parse($data->created_at)->toFormattedDateString();
      $due_date = date('Y-m-d', strtotime('+'.$data->time_period.'days', strtotime($data->created_at)));
      $due_date = Carbon::parse($due_date)->toFormattedDateString();
      return view('transaction/shipping/shipping_details', compact('data', 'date', 'due_date'));
    }

    public function edit($id) {
      $shipping             = Shipping::with('shipping_vehicle', 'shipping_vendor')->find($id);
      $status               = $shipping->status;
      $shipping->shipping_vehicle != null ? $vehicle_plat_number  = $shipping->shipping_vehicle->vehicle_plat_number : $vehicle_plat_number = '';
      $vehicle              = Vehicle::pluck('plat_number', 'plat_number')->toArray();
      return view('transaction/shipping/modal_update', compact('shipping','status', 'vehicle', 'vehicle_plat_number'));
    }

    public function update(Request $request, $id) {
      
      $this->validate($request, [
        'status'   => 'required'
      ]);

      if(!empty($request->input('load_date'))) {
        $load_date                = Carbon::parse($request->input('load_date'));
      } else {
        $load_date                = NULL;
      }
      $operational_cost           = str_replace(".", "", $request->input('operational_cost'));
      $vehicle                    = Vehicle::with('employees')->where('plat_number', $request->vehicle)->first();
      $shipping                   = Shipping::find($id);
      $shipping->status           = $request->input('status');
      $shipping->operational_cost = $operational_cost;
      $shipping->load_date        = $load_date;
      $shipping->updated_by       = Auth::user()->name;
      $shipping->save();

      if ($request->vehicle != null) {
        $shipping_vehicle                           = ShippingVehicle::firstOrCreate(['shipping_id' => $shipping->id]);
        $shipping_vehicle->shipping_id              = $shipping->id;
        $shipping_vehicle->vehicle_id               = $vehicle->id;
        $shipping_vehicle->vehicle_name             = $vehicle->name;
        $shipping_vehicle->vehicle_plat_number      = $request->vehicle;
        $shipping_vehicle->vehicle_type             = $vehicle->type;
        $shipping_vehicle->vehicle_merk             = $vehicle->merk;
        $shipping_vehicle->vehicle_color            = $vehicle->color;
        $shipping_vehicle->vehicle_driver           = $vehicle->employees->name;
        $shipping_vehicle->vehicle_production_year  = $vehicle->production_year;
        $shipping_vehicle->vehicle_tax              = $vehicle->vehicle_tax;
        $shipping_vehicle->vehicle_status           = $vehicle->status;
        $shipping_vehicle->created_by               = Auth::user()->name;
        $shipping_vehicle->save();
      } else {
        $shipping_vehicle                           = ShippingVehicle::where('shipping_id', '=', $shipping->id);
        $shipping_vehicle->delete();
      }

      if ($shipping->shipping_method == 'vendor') {
        $vendor = ShippingVendor::where('shipping_id', '=', $shipping->id)->first();
        $vendor->vendor_driver        = $request->input('vendor_driver');
        $vendor->vendor_license_plate = $request->input('license_plate');
        $vendor->save();
      }

      return response()->json(['responseText' => 'Updated'], 200);
    }

    public function destroy($id) {
      $delete_customer = Shipping::find($id);
      $delete_customer->deleted_by = Auth::user()->id;
      $delete_customer->save();
      $delete_customer->delete();
      return response()->json(['responseText' => 'Deleted'], 200);
    }
}
