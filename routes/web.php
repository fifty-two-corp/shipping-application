<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return redirect()->route('home');
// });

Auth::routes();
Route::group(['middleware' => ['auth']], function() {
	Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index');
	Route::get('logout', 'Auth\LoginController@logout');

	Route::get('get-city/{id}', 'IndonesiaController@getCity');
	Route::get('get-district/{id}', 'IndonesiaController@getDistrict');

	//Profile
	Route::get('profile','ProfileController@index');
	Route::post('profile/photo/store','ProfileController@update_pictures');
	Route::post('profile/update_field','ProfileController@update_field')->name('update_field');
	Route::get('profile/update_password','ProfileController@update_password');
	Route::post('profile/store_password','ProfileController@store_password');

	//Master - Customer
	Route::get('customer','Master\CustomerController@index');
	Route::get('customer/get-customer','Master\CustomerController@getCustomer');
	Route::get('customer/create','Master\CustomerController@create');
	Route::post('customer/store','Master\CustomerController@store');
	Route::get('customer/{id}/edit','Master\CustomerController@edit');
	Route::patch('customer/{id}','Master\CustomerController@update');
	Route::delete('customer/{id}','Master\CustomerController@destroy');

	//Master - Employees
	Route::get('employees','Master\EmployeesController@index');
	Route::get('employees/get-employees','Master\EmployeesController@getEmployees');
	Route::get('employees/create','Master\EmployeesController@create');
	Route::post('employees/store','Master\EmployeesController@store');
	Route::get('employees/{id}/edit','Master\EmployeesController@edit');
	Route::patch('employees/{id}','Master\EmployeesController@update');
	Route::delete('employees/{id}','Master\EmployeesController@destroy');

	//Master - Vendor
	Route::get('vendors','Master\VendorController@index');
	Route::get('vendors/get-vendor','Master\VendorController@getVendor');
	Route::get('vendors/create','Master\VendorController@create');
	Route::post('vendors/store','Master\VendorController@store');
	Route::get('vendors/{id}/edit','Master\VendorController@edit');
	Route::patch('vendors/{id}','Master\VendorController@update');
	Route::delete('vendors/{id}','Master\VendorController@destroy');

	//Master - Service
	Route::get('service','Cost\ServiceController@index');
	Route::get('service/get-service','Cost\ServiceController@getService');
	Route::get('service/create','Cost\ServiceController@create');
	Route::post('service/store','Cost\ServiceController@store');
	Route::get('service/{id}/edit','Cost\ServiceController@edit');
	Route::patch('service/{id}','Cost\ServiceController@update');
	Route::delete('service/{id}','Cost\ServiceController@destroy');

	//Master - Vehicle
	Route::get('vehicle','Master\VehicleController@index');
	Route::get('vehicle/get-vehicle','Master\VehicleController@getVehicle');
	Route::get('vehicle/create','Master\VehicleController@create');
	Route::post('vehicle/store','Master\VehicleController@store');
	Route::get('vehicle/{id}/edit','Master\VehicleController@edit');
	Route::patch('vehicle/{id}','Master\VehicleController@update');
	Route::delete('vehicle/{id}','Master\VehicleController@destroy');

	//Cost - Vendor Cost
	Route::get('vendor-cost','Cost\VendorcostController@index');
	Route::get('vendor-cost/get-vendor-cost','Cost\VendorcostController@getVendorcost');
	Route::get('vendor-cost/create','Cost\VendorcostController@create');
	Route::post('vendor-cost/store','Cost\VendorcostController@store');
	Route::get('vendor-cost/{id}/edit','Cost\VendorcostController@edit');
	Route::patch('vendor-cost/{id}','Cost\VendorcostController@update');
	Route::delete('vendor-cost/{id}','Cost\VendorcostController@destroy')->name('vendor-cost-delete');

	//Cost - Customer Cost
	Route::get('customer-cost','Cost\CustomercostController@index');
	Route::get('customer-cost/get-customer-cost','Cost\CustomercostController@getCustomercost');
	Route::get('customer-cost/create','Cost\CustomercostController@create');
	Route::post('customer-cost/store','Cost\CustomercostController@store');
	Route::get('customer-cost/{id}/edit','Cost\CustomercostController@edit');
	Route::patch('customer-cost/{id}','Cost\CustomercostController@update');
	Route::delete('customer-cost/{id}','Cost\CustomercostController@destroy');

	//Master - City
	Route::get('city','Cost\CityController@index');
	Route::get('city/get-city/{id}','Cost\CityController@getCity');
	Route::get('city/get-data-city/{id}','Cost\CityController@getCityData');
	Route::get('city/get-city-default','Cost\CityController@getCityDefault');
	Route::get('city/create-city','Cost\CityController@createCity');
	Route::post('city/store-city','Cost\CityController@storeCity');
	Route::get('city/{id}/edit-city','Cost\CityController@editCity');
	Route::patch('city/{id}','Cost\CityController@updateCity');
	Route::delete('city/city/{id}','Cost\CityController@destroyCity');

	//Master - Province
	Route::get('city/get-provinces','Cost\CityController@getProvince');
	Route::get('city/create-province','Cost\CityController@createProvince');
	Route::post('city/store-province','Cost\CityController@storeProvince');
	Route::get('city/{id}/edit-province','Cost\CityController@editProvince');
	Route::patch('province/{id}','Cost\CityController@updateProvince');
	Route::delete('city/province/{id}','Cost\CityController@destroyProvince');

	//Transaction - Shipping
	Route::get('shipping','Transaction\ShippingController@index');
	Route::get('shipping/shipping-list','Transaction\ShippingController@ShippingList');
	Route::get('shipping/get-shipping-list','Transaction\ShippingController@getShippingList');
	Route::get('shipping/get-customer-data/{id}','Transaction\ShippingController@getCustomerData');
	Route::get('shipping/get-shipping-mehod-field','Transaction\ShippingController@getShippingMethodField');
	Route::get('shipping/get-default-form/customer/{customer}/destination/{destination}','Transaction\ShippingController@getDefaultForm');
	Route::get('shipping/get-vendor-form/customer/{customer}/province/{province}','Transaction\ShippingController@getVendorForm');
	Route::get('shipping/get-vendor-data/{id}','Transaction\ShippingController@getVendorData');
	Route::get('shipping/get-vendor-shipping-type/customer/{customer}/destination/{destination}/vendor/{vendor}','Transaction\ShippingController@getVendorShippingType');
	Route::get('shipping/get-customer-shipping-type/{id}','Transaction\ShippingController@getCustomerShippingType');
	Route::get('shipping/get-calculation-default-cost/{id}','Transaction\ShippingController@getCalculateDefaultCost');
	Route::get('shipping/get-calculation-vendor-cost/{id}','Transaction\ShippingController@getCalculateVendorCost');
	Route::post('shipping/store','Transaction\ShippingController@store');
	Route::get('shipping/{id}/edit','Transaction\ShippingController@edit');
	Route::delete('shipping/{id}','Transaction\ShippingController@destroy');
	Route::get('shipping/details/{id}', 'Transaction\ShippingController@getShippingDetails');
	Route::get('shipping/invoice/{id}', 'Transaction\ShippingController@invoice');
	Route::get('shipping/pdf/invoice/{id}', 'Transaction\ShippingController@invoicePdf');
	Route::get('shipping/pdf/do/{id}', 'Transaction\ShippingController@doPdf');
	Route::get('shipping/installment-form', 'Transaction\ShippingController@getInstallmentForm');
	Route::patch('shipping/{id}','Transaction\ShippingController@update');

	//Report - Termin
	Route::get('termin','Report\TerminController@index');
	Route::get('termin/get-termin-list','Report\TerminController@getTerminList');
	Route::get('termin/details/{id}', 'Report\TerminController@getTerminDetails');
	Route::get('termin/{id}/edit','Report\TerminController@edit');
	Route::patch('termin/{id}','Report\TerminController@update');

	//Report - General Report
	Route::get('general-report','Report\GeneralReportController@index');
	Route::post('general-report/report-data','Report\GeneralReportController@ReportData');

	// Administrator - Users
	Route::get('users','Administrator\UsersController@index');
  	Route::get('users/get-user','Administrator\UsersController@getUser');
	Route::get('users/create','Administrator\UsersController@create');
	Route::post('users/store','Administrator\UsersController@store');
	Route::get('users/{id}/edit','Administrator\UsersController@edit');
	Route::patch('users/{id}','Administrator\UsersController@update');
	Route::delete('users/{id}','Administrator\UsersController@destroy');

	// Administrator - Role
	Route::get('roles',['as'=>'roles.index','uses'=>'Administrator\RoleController@index','middleware' => ['permission:role-list|role-create|role-edit|role-delete']]);
	Route::get('roles/get-roles',['as'=>'roles.list','uses'=>'Administrator\RoleController@getRole','middleware' => ['permission:role-list']]);
	Route::get('roles/create',['as'=>'roles.create','uses'=>'Administrator\RoleController@create','middleware' => ['permission:role-create']]);
	Route::post('roles/store',['as'=>'roles.store','uses'=>'Administrator\RoleController@store','middleware' => ['permission:role-create']]);
	Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'Administrator\RoleController@edit','middleware' => ['permission:role-edit']]);
	Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'Administrator\RoleController@update','middleware' => ['permission:role-edit']]);
	Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'Administrator\RoleController@destroy','middleware' => ['permission:role-delete']]);
	Route::get('roles/{id}',['as'=>'roles.show','uses'=>'Administrator\RoleController@show','middleware'=>['permission:role-list']]);

	// Administrator - Menu Permission
	Route::get('menu_permission','Administrator\MenuPermissionController@index');
	//Parent Menu
	Route::get('menu_permission/get-parent-menu','Administrator\MenuPermissionController@getParentMenu');
	Route::get('menu_permission/create-parent-menu','Administrator\MenuPermissionController@createParentMenu');
	Route::post('menu_permission/store-parent-menu','Administrator\MenuPermissionController@storeParentMenu');
	Route::get('menu_permission/{id}/edit-parent-menu','Administrator\MenuPermissionController@editParentMenu');
	Route::patch('menu_permission/save-edit-parent-menu/{id}','Administrator\MenuPermissionController@updateParentMenu');
	Route::delete('menu_permission/delete-parent-menu/{id}','Administrator\MenuPermissionController@destroyParentMenu');
	//Child Menu
	Route::get('menu_permission/get-child-menu-default','Administrator\MenuPermissionController@getChildMenuDefault');
	Route::get('menu_permission/get-child-menu-data/{id}','Administrator\MenuPermissionController@getChildMenuData');
	Route::get('menu_permission/get-data-child/{id}','Administrator\MenuPermissionController@getDataChild');
	Route::get('menu_permission/create-child-menu','Administrator\MenuPermissionController@createChildMenu');
	Route::post('menu_permission/store-child-menu','Administrator\MenuPermissionController@storeChildMenu');
	Route::get('menu_permission/{id}/edit-child-menu','Administrator\MenuPermissionController@editChildMenu');
	Route::patch('menu_permission/save-edit-child-menu/{id}','Administrator\MenuPermissionController@updateChildMenu');
	Route::delete('menu_permission/delete-child-menu/{id}','Administrator\MenuPermissionController@destroyChildMenu');
	//Permission
	Route::get('menu_permission/get-permission-default','Administrator\MenuPermissionController@getPermissionDefault');
	Route::get('menu_permission/get-permission-data/{id}','Administrator\MenuPermissionController@getPermissionData');
	Route::get('menu_permission/get-data-permission/{id}','Administrator\MenuPermissionController@getDataPermission');
	Route::get('menu_permission/create-permission','Administrator\MenuPermissionController@createPermission');
	Route::post('menu_permission/store-permission','Administrator\MenuPermissionController@storePermission');
	Route::get('menu_permission/{id}/edit-permission','Administrator\MenuPermissionController@editPermission');
	Route::patch('menu_permission/save-edit-permission/{id}','Administrator\MenuPermissionController@updatePermission');
	Route::delete('menu_permission/delete-permission/{id}','Administrator\MenuPermissionController@destroyPermission');

	// Route::get('itemCRUD2',['as'=>'itemCRUD2.index','uses'=>'ItemCRUD2Controller@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);
	// Route::get('itemCRUD2/create',['as'=>'itemCRUD2.create','uses'=>'ItemCRUD2Controller@create','middleware' => ['permission:item-create']]);
	// Route::post('itemCRUD2/create',['as'=>'itemCRUD2.store','uses'=>'ItemCRUD2Controller@store','middleware' => ['permission:item-create']]);
	// Route::get('itemCRUD2/{id}',['as'=>'itemCRUD2.show','uses'=>'ItemCRUD2Controller@show']);
	// Route::get('itemCRUD2/{id}/edit',['as'=>'itemCRUD2.edit','uses'=>'ItemCRUD2Controller@edit','middleware' => ['permission:item-edit']]);
	// Route::patch('itemCRUD2/{id}',['as'=>'itemCRUD2.update','uses'=>'ItemCRUD2Controller@update','middleware' => ['permission:item-edit']]);
	// Route::delete('itemCRUD2/{id}',['as'=>'itemCRUD2.destroy','uses'=>'ItemCRUD2Controller@destroy','middleware' => ['permission:item-delete']]);

	// Administrator - Backup
	Route::get('backup','Administrator\BackupController@index');
	Route::get('backup/get-backup-data','Administrator\BackupController@getBackupData');
	Route::get('backup/backup','Administrator\BackupController@backup');
	Route::get('backup/download/{name}','Administrator\BackupController@download');
	Route::get('backup/delete/{name}','Administrator\BackupController@destroy');

});
