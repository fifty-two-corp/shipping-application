<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission {
  use SoftDeletes;
  
  protected $dates = ['deleted_at'];
  public $fillable = ['id','name','display_name','description'];

  public function parent_menu() {
      return $this->belongsToMany('App\ParentMenu');
  }

  public function roles() {
      return $this->belongsToMany('App\Role');
  }

  public function child_menu() {
      return $this->belongsTo('App\ChildMenu');
  }
}
