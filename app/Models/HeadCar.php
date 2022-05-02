<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadCar extends Model {

  protected $table = 'cars_cylinder_head';
  public $timestamps = false;

  protected $fillable = [
    'cars_id',
    'cylinder_head_id'
  ];

}