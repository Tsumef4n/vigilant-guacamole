<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $table = 'products'; // not needed, eloquent sucht nach Pluralform vom Klassennamen

  protected $fillable = [
    'name',
    'description',
  ];

};
