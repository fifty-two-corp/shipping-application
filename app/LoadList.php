<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoadList extends Model {

  protected $table = 'load_list';
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

  public function shipping() {
	  return $this->belongsTo('App\Shipping');
	}
}
