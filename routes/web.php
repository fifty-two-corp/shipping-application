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
	Route::get('/',['as'=>'dashboard.index','uses'=>'HomeController@index']);
	Route::get('logout', ['as'=>'logout','uses'=>'Auth\LoginController@logout']);

	Route::get('get-city/{id}',['as'=>'get_city','uses'=>'IndonesiaController@getCity']);
	Route::get('get-district/{id}',['as'=>'get_district','uses'=>'IndonesiaController@getDistrict']);

	//Profile
	Route::get('profile',['as'=>'profile.index','uses'=>'ProfileController@index']);
	Route::post('profile/photo/store',['as'=>'profile.photo_store','uses'=>'ProfileController@update_pictures']);
	Route::post('profile/update_field',['as'=>'update_field','uses'=>'ProfileController@update_field']);
	Route::get('profile/update_password',['as'=>'profile.update_password','uses'=>'ProfileController@update_password']);
	Route::post('profile/store_password',['as'=>'profile.store_password','uses'=>'ProfileController@store_password']);

	//Master - Customer
	Route::get('customer',['as'=>'customer.index','uses'=>'Master\CustomerController@index']);
	Route::get('customer/get-customer',['as'=>'customer.list','uses'=>'Master\CustomerController@getCustomer']);
	Route::get('customer/create',['as'=>'customer.create','uses'=>'Master\CustomerController@create']);
	Route::post('customer/store',['as'=>'customer.store','uses'=>'Master\CustomerController@store']);
	Route::get('customer/{id}/edit',['as'=>'customer.edit','uses'=>'Master\CustomerController@edit']);
	Route::patch('customer/{id}',['as'=>'customer.update','uses'=>'Master\CustomerController@update']);
	Route::delete('customer/{id}',['as'=>'customer.delete','uses'=>'Master\CustomerController@destroy']);

	//Master - Employees
	Route::get('employees',['as'=>'employees.index','uses'=>'Master\EmployeesController@index']);
	Route::get('employees/get-employees',['as'=>'employees.list','uses'=>'Master\EmployeesController@getEmployees']);
	Route::get('employees/create',['as'=>'employees.create','uses'=>'Master\EmployeesController@create']);
	Route::post('employees/store',['as'=>'employees.store','uses'=>'Master\EmployeesController@store']);
	Route::get('employees/{id}/edit',['as'=>'employees.edit','uses'=>'Master\EmployeesController@edit']);
	Route::patch('employees/{id}',['as'=>'employees.update','uses'=>'Master\EmployeesController@update']);
	Route::delete('employees/{id}',['as'=>'employees.delete','uses'=>'Master\EmployeesController@destroy']);

	//Master - Vendor
	Route::get('vendors',['as'=>'vendors.index','uses'=>'Master\VendorController@index']);
	Route::get('vendors/get-vendor',['as'=>'vendors.list','uses'=>'Master\VendorController@getVendor']);
	Route::get('vendors/create',['as'=>'vendors.create','uses'=>'Master\VendorController@create']);
	Route::post('vendors/store',['as'=>'vendors.store','uses'=>'Master\VendorController@store']);
	Route::get('vendors/{id}/edit',['as'=>'vendors.edit','uses'=>'Master\VendorController@edit']);
	Route::patch('vendors/{id}',['as'=>'vendors.update','uses'=>'Master\VendorController@update']);
	Route::delete('vendors/{id}',['as'=>'vendors.delete','uses'=>'Master\VendorController@destroy']);

	//Master - Service
//	Route::get('service','Cost\ServiceController@index');
//	Route::get('service/get-service','Cost\ServiceController@getService');
//	Route::get('service/create','Cost\ServiceController@create');
//	Route::post('service/store','Cost\ServiceController@store');
//	Route::get('service/{id}/edit','Cost\ServiceController@edit');
//	Route::patch('service/{id}','Cost\ServiceController@update');
//	Route::delete('service/{id}','Cost\ServiceController@destroy');

	//Master - Vehicle
	Route::get('vehicle',['as'=>'vehicle.index','uses'=>'Master\VehicleController@index']);
	Route::get('vehicle/get-vehicle',['as'=>'vehicle.list','uses'=>'Master\VehicleController@getVehicle']);
	Route::get('vehicle/create',['as'=>'vehicle.create','uses'=>'Master\VehicleController@create']);
	Route::post('vehicle/store',['as'=>'vehicle.store','uses'=>'Master\VehicleController@store']);
	Route::get('vehicle/{id}/edit',['as'=>'vehicle.edit','uses'=>'Master\VehicleController@edit']);
	Route::patch('vehicle/{id}',['as'=>'vehicle.update','uses'=>'Master\VehicleController@update']);
	Route::delete('vehicle/{id}',['as'=>'vehicle.delete','uses'=>'Master\VehicleController@destroy']);

	//Cost - Vendor Cost
	Route::get('vendor-cost',['as'=>'vendor-cost.index','uses'=>'Cost\VendorcostController@index']);
	Route::get('vendor-cost/get-vendor-cost',['as'=>'vendor-cost.list','uses'=>'Cost\VendorcostController@getVendorcost']);
	Route::get('vendor-cost/create',['as'=>'vendor-cost.create','uses'=>'Cost\VendorcostController@create']);
	Route::post('vendor-cost/store',['as'=>'vendor-cost.store','uses'=>'Cost\VendorcostController@store']);
	Route::get('vendor-cost/{id}/edit',['as'=>'vendor-cost.edit','uses'=>'Cost\VendorcostController@edit']);
	Route::patch('vendor-cost/{id}',['as'=>'vendor-cost','uses'=>'Cost\VendorcostController@update']);
	Route::delete('vendor-cost/{id}',['as'=>'vendor-cost-delete','uses'=>'Cost\VendorcostController@destroy']);

	//Cost - Customer Cost
	Route::get('customer-cost',['as'=>'customer-cost.index','uses'=>'Cost\CustomercostController@index']);
	Route::get('customer-cost/get-customer-cost',['as'=>'customer-cost.list','uses'=>'Cost\CustomercostController@getCustomercost']);
	Route::get('customer-cost/create',['as'=>'customer-cost.create','uses'=>'Cost\CustomercostController@create']);
	Route::post('customer-cost/store',['as'=>'customer-cost.store','uses'=>'Cost\CustomercostController@store']);
	Route::get('customer-cost/{id}/edit',['as'=>'customer-cost.edit','uses'=>'Cost\CustomercostController@edit']);
	Route::patch('customer-cost/{id}',['as'=>'customer-cost.update','uses'=>'Cost\CustomercostController@update']);
	Route::delete('customer-cost/{id}',['as'=>'customer-cost.delete','uses'=>'Cost\CustomercostController@destroy']);

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

	//Transaction - Termin
	Route::get('termin',['as'=>'termin.index','uses'=>'Transaction\TerminController@index']);
	Route::get('termin/get-termin-list',['as'=>'termin.list','uses'=>'Transaction\TerminController@getTerminList']);
	Route::get('termin/details/{id}', ['as'=>'termin.details','uses'=>'Transaction\TerminController@getTerminDetails']);
	Route::get('termin/{id}/edit',['as'=>'termin.edit','uses'=>'Transaction\TerminController@edit']);
	Route::patch('termin/{id}',['as'=>'termin.update','uses'=>'Transaction\TerminController@update']);

	//Report - General Report
	Route::get('general-report',['as'=>'general-report.index','uses'=>'Report\GeneralReportController@index']);
	Route::post('general-report/report-data',['as'=>'general-report.data','uses'=>'Report\GeneralReportController@ReportData']);
  Route::get('general-report/pdf/{date_start}/{date_end}',['as'=>'general-report.pdf','uses'=>'Report\GeneralReportController@general_report_pdf']);

  //Report - DO Out
  Route::get('do-report',['as'=>'do-report.index','uses'=>'Report\DoReportController@index']);
  Route::get('do-report/get-do',['as'=>'do-report.list','uses'=>'Report\DoReportController@getDO']);
  Route::get('do-report/{id}/edit',['as'=>'do-report.edit','uses'=>'Report\DoReportController@edit']);
  Route::patch('do-report/{id}',['as'=>'do-report.update','uses'=>'Report\DoReportController@update']);
  Route::delete('do-report/{id}',['as'=>'do-report.delete','uses'=>'Report\DoReportController@destroy']);

	// Administrator - Users
	Route::get('users',['as'=>'users.index','uses'=>'Administrator\UsersController@index']);
	Route::get('users/get-user',['as'=>'users.list','uses'=>'Administrator\UsersController@getUser']);
	Route::get('users/create',['as'=>'users.create','uses'=>'Administrator\UsersController@create']);
	Route::post('users/store',['as'=>'users.store','uses'=>'Administrator\UsersController@store']);
	Route::get('users/{id}/edit',['as'=>'users.edit','uses'=>'Administrator\UsersController@edit']);
	Route::patch('users/{id}',['as'=>'users.update','uses'=>'Administrator\UsersController@update']);
	Route::delete('users/{id}',['as'=>'users.delete','uses'=>'Administrator\UsersController@destroy']);

	// Administrator - Role
	Route::get('roles',['as'=>'roles.index','uses'=>'Administrator\RoleController@index','middleware' => ['permission:role-list|role-create|role-edit|role-delete']]);
	Route::get('roles/get-roles',['as'=>'roles.list','uses'=>'Administrator\RoleController@getRole','middleware' => ['permission:role-list']]);
	Route::get('roles/create',['as'=>'roles.create','uses'=>'Administrator\RoleController@create','middleware' => ['permission:create-role']]);
	Route::post('roles/store',['as'=>'roles.store','uses'=>'Administrator\RoleController@store','middleware' => ['permission:create-role']]);
	Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'Administrator\RoleController@edit','middleware' => ['permission:update-role']]);
	Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'Administrator\RoleController@update','middleware' => ['permission:update-role']]);
	Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'Administrator\RoleController@destroy','middleware' => ['permission:delete-role']]);
	Route::get('roles/{id}',['as'=>'roles.show','uses'=>'Administrator\RoleController@show','middleware'=>['permission:role-list']]);

	// Administrator - Menu Permission
	Route::get('menu_permission',['as'=>'menu_permission.index','uses'=>'Administrator\MenuPermissionController@index']);

	//Administrator - Parent Menu
	Route::get('menu_permission/get-parent-menu',['as'=>'menu_permission-parent.menu','uses'=>'Administrator\MenuPermissionController@getParentMenu']);
	Route::get('menu_permission/create-parent-menu',['as'=>'menu_permission-parent.create','uses'=>'Administrator\MenuPermissionController@createParentMenu']);
	Route::post('menu_permission/store-parent-menu',['as'=>'menu_permission-parent.store','uses'=>'Administrator\MenuPermissionController@storeParentMenu']);
	Route::get('menu_permission/{id}/edit-parent-menu',['as'=>'menu_permission-parent.edit','uses'=>'Administrator\MenuPermissionController@editParentMenu']);
	Route::patch('menu_permission/save-edit-parent-menu/{id}',['as'=>'menu_permission-parent.update','uses'=>'Administrator\MenuPermissionController@updateParentMenu']);
	Route::delete('menu_permission/delete-parent-menu/{id}',['as'=>'menu_permission-parent.delete','uses'=>'Administrator\MenuPermissionController@destroyParentMenu']);
	
	// Administrator - Child Menu
	Route::get('menu_permission/get-child-menu-default',['as'=>'menu_permission-child.index','uses'=>'Administrator\MenuPermissionController@getChildMenuDefault']);
	Route::get('menu_permission/get-child-menu-data/{id}',['as'=>'menu_permission-child.menu-data','uses'=>'Administrator\MenuPermissionController@getChildMenuData']);
	Route::get('menu_permission/get-data-child/{id}',['as'=>'menu_permission-child.data','uses'=>'Administrator\MenuPermissionController@getDataChild']);
	Route::get('menu_permission/create-child-menu',['as'=>'menu_permission-child.create','uses'=>'Administrator\MenuPermissionController@createChildMenu']);
	Route::post('menu_permission/store-child-menu',['as'=>'menu_permission-child.store','uses'=>'Administrator\MenuPermissionController@storeChildMenu']);
	Route::get('menu_permission/{id}/edit-child-menu',['as'=>'menu_permission-child.edit','uses'=>'Administrator\MenuPermissionController@editChildMenu']);
	Route::patch('menu_permission/save-edit-child-menu/{id}',['as'=>'menu_permission-child.update','uses'=>'Administrator\MenuPermissionController@updateChildMenu']);
	Route::delete('menu_permission/delete-child-menu/{id}',['as'=>'menu_permission-child.delete','uses'=>'Administrator\MenuPermissionController@destroyChildMenu']);
	
	// Administrator - Permission
	Route::get('menu_permission/get-permission-default',['as'=>'menu_permission-permission.permission','uses'=>'Administrator\MenuPermissionController@getPermissionDefault']);
	Route::get('menu_permission/get-permission-data/{id}',['as'=>'menu_permission-permission.data','uses'=>'Administrator\MenuPermissionController@getPermissionData']);
	Route::get('menu_permission/get-data-permission/{id}',['as'=>'menu_permission-permission.permission-data','uses'=>'Administrator\MenuPermissionController@getDataPermission']);
	Route::get('menu_permission/create-permission',['as'=>'menu_permission-permission.create','uses'=>'Administrator\MenuPermissionController@createPermission']);
	Route::post('menu_permission/store-permission',['as'=>'menu_permission-permission.store','uses'=>'Administrator\MenuPermissionController@storePermission']);
	Route::get('menu_permission/{id}/edit-permission',['as'=>'menu_permission-permission.edit','uses'=>'Administrator\MenuPermissionController@editPermission']);
	Route::patch('menu_permission/save-edit-permission/{id}',['as'=>'menu_permission-permission.update','uses'=>'Administrator\MenuPermissionController@updatePermission']);
	Route::delete('menu_permission/delete-permission/{id}',['as'=>'menu_permission-permission.delete','uses'=>'Administrator\MenuPermissionController@destroyPermission']);

	// Administrstor - Activity Log
	Route::get('activitylog',['as'=>'activitylog.index','uses'=>'Administrator\ActivitylogController@index']);
	Route::get('activitylog/get-logs',['as'=>'activitylog.list','uses'=>'Administrator\ActivitylogController@getActivitylog']);
	Route::get('activitylog/get-logs-details/{id}',['as'=>'activitylog.details','uses'=>'Administrator\ActivitylogController@show']);
	Route::delete('activitylog/delete-logs/{id}',['as'=>'activitylog.delete','uses'=>'Administrator\ActivitylogController@destroy']);
	Route::get('activitylog/clean-logs',['as'=>'activitylog.clear','uses'=>'Administrator\ActivitylogController@clean']);

	// Settings - Environment
	Route::get('environment',['as'=>'environment.index','uses'=>'Settings\EnvironmentController@index','middleware'=>['permission:environment-list']]);
	Route::get('environment/get-env',['as'=>'environment.data','uses'=>'Settings\EnvironmentController@getEnv','middleware'=>['permission:environment-list']]);
	Route::get('environment/create',['as'=>'environment.create','uses'=>'Settings\EnvironmentController@create','middleware'=>['permission:create-environment']]);
	Route::post('environment/store',['as'=>'environment.store','uses'=>'Settings\EnvironmentController@store','middleware'=>['permission;create-environment']]);
	Route::get('environment/{name}/edit/{value}',['as'=>'environment.edit','uses'=>'Settings\EnvironmentController@edit','middleware'=>['permission:update-environment']]);
	Route::patch('environment/{name}',['as'=>'environment.update','uses'=>'Settings\EnvironmentController@update','middleware'=>['permission:update-environment']]);
	Route::get('environment/delete-env/{name}',['as'=>'environment.delete','uses'=>'Settings\EnvironmentController@destroy','middleware'=>['permission:delete-environment']]);

	// Settings - Backup
	Route::get('backup',['as'=>'backup.index', 'uses'=>'Settings\BackupController@index','middleware'=>['permission:backup-list']]);
	Route::get('backup/get-backup-data',['as'=>'backup.data','uses'=>'Settings\BackupController@getBackupData','middleware'=>['permission:backup-list']]);
	Route::get('backup/backup',['as'=>'backup.backup','uses'=>'Settings\BackupController@backup','middleware'=>['permission:create-backup']]);
	Route::get('backup/download/{name}',['as'=>'backup.download','uses'=>'Settings\BackupController@download','middleware'=>['permission:download-backup']]);
	Route::get('backup/delete/{name}',['as'=>'backup.delete','uses'=>'Settings\BackupController@destroy','middleware'=>['permission:delete-backup']]);

	// Administrator - Settings
  Route::get('settings',['as'=>'setings.index','uses'=>'Administrator\SettingsController@index','middleware'=> ['permission:view-settings']]);
  Route::patch('settings/bank-settings/{id}',['as'=>'settings.save_data_bank','uses'=>'Administrator\SettingsController@save_data_bank','middleware'=> ['permission:update-settings']]);
});
