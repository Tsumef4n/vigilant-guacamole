<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Press extends Model
{
    protected $table = 'press'; // not needed, eloquent sucht nach Pluralform vom Klassennamen

  protected $fillable = [
    'title',
    'text',
  ];
}
