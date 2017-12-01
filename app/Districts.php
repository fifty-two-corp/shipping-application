<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model {

  protected $table = 'indonesia_districts';
  protected $guarded = [];

  public function provinces() {
  	return $this->belongsTo('App\Provinces');
  }

  public function city() {
  	return $this->belongsTo('App\City');
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

}
