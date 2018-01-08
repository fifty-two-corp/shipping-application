<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorCost extends Model {

  protected $table = 'vendor_cost';
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

  public function destination_city() {
    return $this->belongsTo('App\City');
  }

	public function origin_provinces() {
	  return $this->belongsTo('App\Provinces');
	}

  public function origin_city() {
    return $this->belongsTo('App\City');
  }

}