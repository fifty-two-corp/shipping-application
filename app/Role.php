<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends EntrustRole {
	use LogsActivity;

	protected static $logAttributes = [
    'id',
    'name',
    'display_name',
    'description',
    'created_at',
    'updated_at'
  ];
  
  public function user() {
    return $this->belongsToMany('App\User');
  }

  public function permission() {
    return $this->belongsToMany('App\Permission');
  }
}
