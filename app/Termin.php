<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Termin extends Model {
  use SoftDeletes;
  use LogsActivity;

  protected $table = 'termin_payment';
  protected $dates = ['deleted_at'];
  protected $guarded = [];
  protected static $logAttributes = [
    'id',
    'shipping_id',
    'payment',
    'payment_date',
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

  public function shipping() {
	  return $this->belongsTo('App\Shipping');
	}
}
