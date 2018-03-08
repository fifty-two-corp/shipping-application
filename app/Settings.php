<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Settings extends Model {
  use SoftDeletes;
  use LogsActivity;

  protected $table = 'settings';
  protected $dates = ['deleted_at'];
  protected $guarded = [];
  protected static $logAttributes = [
    'id',
    'bank_name',
    'bank_account',
    'bank_number'
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

}
