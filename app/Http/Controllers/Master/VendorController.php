<?phpnamespace App\Http\Controllers\Master;use Illuminate\Http\Request;use App\Http\Controllers\Controller;use App\Vendor;use App\VendorCost;use App\Provinces;use App\City;use App\IdMethod;use Auth;use DB;use Datatables;use Indonesia;class VendorController extends Controller {  	public function index() {		return view('master/vendor/index');	} 	public function getVendor(Request $request) { 		if($request->ajax()){      $vendor = Vendor::with('province', 'city', 'districts')->get(); 			return Datatables::of($vendor)      ->editColumn('province', function ($vendor) {        return $vendor->province? with($vendor->province->name) : '';      })      ->editColumn('city', function ($vendor) {        return $vendor->city? with($vendor->city->name) : '';      })      ->editColumn('districts', function ($vendor) {        return $vendor->districts? with($vendor->districts->name) : '';      })      ->make(true); 		} else { 			return abort(404); 		} 	} 	public function create() {    $province = Indonesia::allProvinces()->pluck('name','id')->toArray();    return view('master/vendor/modal_add', compact('province')); 	}  public function store(Request $request) {    $this->validate($request, [      'vendor_number'   => 'required|unique:vendor,vendor_number',      'name'              => 'required',      'address'           => 'required',      'province'          => 'required',      'city'              => 'required',      'phone'             => 'required',    ]);    $vendor                   = new Vendor();    $vendor->vendor_number    = $request->input('vendor_number');    $vendor->name             = $request->input('name');    $vendor->address          = $request->input('address');    $vendor->province_id      = $request->input('province');    $vendor->city_id          = $request->input('city');    $vendor->districts_id     = $request->input('districts');    $vendor->phone            = $request->input('phone');    $vendor->created_by       = Auth::user()->id;    $vendor->save();    return response()->json(['responseText' => 'Success'], 200);  }  public function edit($id) {    $vendor           = Vendor::find($id);    $province         = Indonesia::allProvinces()->pluck('name','id')->toArray();    $vendor_province  = $vendor->province_id;    $city_vendor      = $vendor->city_id;    $district_vendor  = $vendor->districts_id;    $city             = Indonesia::findProvince($vendor_province, ['cities']);    $city             = null === $city ? [] : $city->cities->pluck('name', 'id')->toArray();    $districts        = Indonesia::findCity($city_vendor, ['districts']);    $districts        = null === $districts ? [] : $districts->districts->pluck('name', 'id')->toArray();    return view('master/vendor/modal_edit',      compact(        'vendor',         'province',         'vendor_province',         'city_vendor',         'city',        'district_vendor',        'districts'      )    );  }  public function update(Request $request, $id) {        $vendor                   = Vendor::find($id);        $this->validate($request, [      'vendor_number'   => 'required | unique:vendor,vendor_number,'.$vendor->id,      'name'              => 'required',      'address'           => 'required',      'province'          => 'required',      'city'              => 'required',      'phone'             => 'required',    ]);    $vendor->vendor_number    = $request->input('vendor_number');    $vendor->name             = $request->input('name');    $vendor->address          = $request->input('address');    $vendor->province_id      = $request->input('province');    $vendor->city_id          = $request->input('city');    $vendor->districts_id     = $request->input('districts');    $vendor->phone            = $request->input('phone');    $vendor->updated_by       = Auth::user()->id;    $vendor->save();    return response()->json(['responseText' => 'Updated'], 200);  }  public function destroy($id) {    $delete_vendor = Vendor::find($id);    $delete_vendor->deleted_by = Auth::user()->id;    $delete_vendor->save();    $delete_vendor->delete();    return response()->json(['responseText' => 'Deleted'], 200);  }}