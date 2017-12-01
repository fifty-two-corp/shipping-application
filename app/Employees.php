<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employees extends Model {
  use SoftDeletes;

  protected $table = 'employees';
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

  public function province() {
	  return $this->belongsTo('App\Provinces');
	}

  public function city() {
    return $this->belongsTo('App\City');
  }

  public function districts() {
    return $this->belongsTo('App\Districts');
  }

  public function id_method() {
    return $this->belongsTo('App\IdMethod','identity_method_id');
  }

  public function vehicle() {
    return $this->hasMany('App\Vehicle');
  }

}
