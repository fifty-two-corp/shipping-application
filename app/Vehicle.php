<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Vehicle extends Model {
	use SoftDeletes;
	use LogsActivity;

  protected $table = 'vehicle';
  protected $dates = ['deleted_at'];
  protected $guarded = [];
  protected static $logAttributes = [
    'id',
    'plat_number',
    'name',
    'employees_id',
    'type',
    'merk',
    'color',
    'production_year',
    'vehicle_tax',
    'status'
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

  public function employees() {
  	return $this->belongsTo('App\Employees');
  }

}
