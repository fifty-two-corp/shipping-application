<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParentMenu extends Model {
	use SoftDeletes;

	protected $table = 'parent_menu';
	protected $dates = ['deleted_at'];
	protected $guarded = [];

  	public function child_menu() {
		return $this->hasMany('App\ChildMenu');
  	}

  	public function permission() {
      	return $this->belongsToMany('App\Permission');
  	}
}