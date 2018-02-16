<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Vendor extends Model {
  use SoftDeletes;
  use LogsActivity;

  protected $table = 'vendor';
  protected $dates = ['deleted_at'];
  protected $guarded = [];
  protected static $logAttributes = [
    'id',
    'vendor_number',
    'name',
    'address',
    'province_id',
    'city_id',
    'districts_id',
    'phone'
  ];

  protected static function boot() {
    parent::boot();
    static::deleting(function($vendor) {
      foreach ($vendor->vendor_cost()->get() as $vendor_cost) {
        $vendor_cost->delete();
      }
    });
  }

  public function created_user() {
    return $this->belongsTo('App\User', 'created_by');
  }

  public function updated_user() {
    return $this->belongsTo('App\User', 'updated_by');
  }

  public function deleted_user() {
    return $this->belongsTo('App\User', 'deleted_by');
  }

  public function vendor_cost() {
	 return $this->hasMany('App\VendorCost');
	}

	public function province() {
	  return $this->belongsTo('App\Provinces');
	}

  public function city() {
    return $this->belongsTo('App\City');
  }

  public function districts() {
    return $this->belongsTo('App\Districts');
  }
}