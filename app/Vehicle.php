<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model {
	use SoftDeletes;

  protected $table = 'vehicle';
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

  public function employees() {
  	return $this->belongsTo('App\Employees');
  }

}
