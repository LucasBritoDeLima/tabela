<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

  protected $table = 'users';

  protected $fillable = [
    'username',
    'password',
    'email'
  ];

  public function permissions() {
    return $this->hasOne('App\Models\UserPermission', 'user_id');
  }
}