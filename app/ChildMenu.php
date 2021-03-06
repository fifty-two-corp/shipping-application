<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildMenu extends Model {
	use SoftDeletes;

	protected $table = 'child_menu';
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

  public function permission() {
    return $this->hasMany('App\Permission');
  }

  public function parent_menu() {
    return $this->belongsTo('App\ParentMenu');
  }
}
