<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model {
	use SoftDeletes;

	protected $table = 'service';
	protected $dates = ['deleted_at'];
	protected $guard = [];

	public function created_user() {
	  return $this->belongsTo('App\User', 'created_by');
	}

	public function updated_user() {
	  return $this->belongsTo('App\User', 'updated_by');
	}

	public function deleted_user() {
	  return $this->belongsTo('App\User', 'deleted_by');
	}

}
