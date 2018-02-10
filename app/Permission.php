<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustPermission;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends EntrustPermission {
  use SoftDeletes;
  use LogsActivity;
  
  protected $dates = ['deleted_at'];
  public $fillable = ['id','name','display_name','description'];
  protected static $logAttributes = [
    'id',
    'name',
    'display_name',
    'description',
    'child_menu_id',
    'created_at',
    'updated_at'
  ];

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
