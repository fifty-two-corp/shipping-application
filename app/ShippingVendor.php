<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingVendor extends Model {

  protected $table = 'shipping_vendor';
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

  public function shipping() {
	  return $this->belongsTo('App\Shipping');
	}
}
