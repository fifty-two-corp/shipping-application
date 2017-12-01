<?php

namespace App;

//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
  use EntrustUserTrait;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password', 'username',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  public function customer() {
    return $this->hasMany('App\Customer');
  }

  public function vendor() {
    return $this->hasMany('App\Vendor');
  }

  public function employees() {
    return $this->hasMany('App\Employees');
  }

  public function vehicle() {
    return $this->hasMany('App\Vehicle');
  }

  public function customer_cost() {
    return $this->hasMany('App\CustomerCost');
  }

  public function vendor_cost() {
    return $this->hasMany('App\VendorCost');
  }

  public function service() {
    return $this->hasMany('App\Service');
  }

  public function id_method() {
    return $this->hasMany('App\IdMethod');
  }
}
