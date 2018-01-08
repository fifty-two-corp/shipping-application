<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model {

  protected $table = 'indonesia_cities';
  protected $guarded = [];

  public function provinces() {
  	return $this->belongsTo('App\Provinces');
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

  public function customer_cost() {
    return $this->hasMany('App\CustomerCost');
  }

  public function vendor_cost() {
    return $this->hasMany('App\VendorCost');
  }

}
