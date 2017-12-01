<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model {

  protected $table = 'indonesia_provinces';
  protected $guarded = [];

  public function vendor_cost() {
	 return $this->hasMany('App\VendorCost');
  }

  public function customer_cost() {
	 return $this->hasMany('App\CustomerCost');
  }

  public function customer() {
    return $this->hasMany('App\Customer');
  }

  public function vendor() {
    return $this->hasMany('App\Vendor');
  }

  public function employess() {
    return $this->hasMany('App\Employess');
  }

  public function city() {
  	return $this->belongsToMany('App\City');
  } 

}
