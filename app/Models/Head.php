<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Head extends Model {

  protected $table = 'cylinder_head';

  protected $fillable = [
    'fuel',
    'material_kind',
    'name_engine',
    'standard_height',
    'minimum_height',
    'observation'
  ];
}