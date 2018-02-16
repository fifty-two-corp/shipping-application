<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class CustomerCost extends Model {
  use SoftDeletes;
  use LogsActivity;

  protected $table = 'customer_cost';
  protected $dates = ['deleted_at'];
  protected $guarded = [];
  protected static $logAttributes = [
    'id',
    'customer_id',
    'origin_provinces_id',
    'origin_city_id',
    'destination_provinces_id',
    'destination_city_id',
    'cost',
    'type',
    'created_at',
    'updated_at'
  ];

  public function created_user() {
    return $this->belongsTo('App\User', 'created_by');
  }

  public function updated_user() {
    return $this->belongsTo('App\User', 'updated_by');
  }

  public function deleted_user() {
    return $this->belongsTo('App\User', 'deleted_by');
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