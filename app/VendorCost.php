<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorCost extends Model {
  use SoftDeletes;

  protected $table = 'vendor_cost';
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

  public function vendor() {
	  return $this->belongsTo('App\Vendor');
	}

	public function customer() {
	  return $this->belongsTo('App\Customer');
	}

	public function destination_provinces() {
	  return $this->belongsTo('App\Provinces');
	}

	public function origin_provinces() {
	  return $this->belongsTo('App\Provinces');
	}

}