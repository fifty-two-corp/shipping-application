<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model {
  use SoftDeletes;

  protected $table = 'shipping';
  protected $dates = ['deleted_at'];
  protected $guarded = [];

  public function created_user() {
    return $this->belongsTo('App\User', 'created_by');
  }

  public function updated_user() {
    return $this->belongsTo('App\User', 'updated_by');
  }

  public function deleted_user() {
    return $this->belongsTo('App\User', 'deleted_by');
  }

  public function shipping_customer() {
    return $this->hasOne('App\ShippingCustomer');
  }

  public function shipping_destination() {
    return $this->hasOne('App\ShippingDestination');
  }

  public function shipping_vendor() {
    return $this->hasOne('App\ShippingVendor');
  }

  public function load_list() {
    return $this->hasMany('App\LoadList');
  }

  public function shipping_vehicle() {
    return $this->hasOne('App\ShippingVehicle');
  }
}
