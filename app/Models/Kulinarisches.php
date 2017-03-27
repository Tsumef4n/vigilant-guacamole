<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kulinarisches extends Model
{
    protected $table = 'kulinarisches'; // not needed, eloquent sucht nach Pluralform vom Klassennamen

  protected $fillable = [
    'month',
    'year',
    'image',
  ];
}
