<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildMenu extends Model {
	use SoftDeletes;

	protected $table = 'child_menu';
	protected $dates = ['deleted_at'];
  protected $guarded = [];

  public function permission() {
    return $this->hasMany('App\Permission');
  }

  public function parent_menu() {
    return $this->belongsTo('App\ParentMenu');
  }
}
