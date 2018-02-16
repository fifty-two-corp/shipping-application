<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Shipping extends Model {
  use SoftDeletes;
  use LogsActivity;

  protected $table = 'shipping';
  protected $dates = ['deleted_at'];
  protected $guarded = [];
  protected static $logAttributes = [
    'id',
    'transaction_number',
    'default_type',
    'default_cost',
    'vendor_type',
    'vendor_cost',
    'tax_value',
    'tax_cost',
    'shipping_method',
    'operational_cost',
    'cost',
    'down_payment',
    'time_period',
    'load_date',
    'status',
    'created_at',
    'updated_at'
  ];

  /**
   * Delete data relation
   */
  protected static function boot() {
    parent::boot();
    static::deleting(function($shipping) {
      foreach ($shipping->termin()->get() as $termin) {
        $termin->delete();
      }
    });
    static::deleting(function($shipping) {
      foreach ($shipping->shipping_destination()->get() as $shipping_destination) {
        $shipping_destination->delete();
      }
    });
    static::deleting(function($shipping) {
      foreach ($shipping->shipping_customer()->get() as $shipping_customer) {
        $shipping_customer->delete();
      }
    });
    static::deleting(function($shipping) {
      foreach ($shipping->shipping_vendor()->get() as $shipping_vendor) {
        $shipping_vendor->delete();
      }
    });
    static::deleting(function($shipping) {
      foreach ($shipping->load_list()->get() as $load_list) {
        $load_list->delete();
      }
    });
    static::deleting(function($shipping) {
      foreach ($shipping->shipping_vehicle()->get() as $shipping_vehicle) {
        $shipping_vehicle->delete();
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

  public function termin() {
    return $this->hasMany('App\Termin');
  }
}
