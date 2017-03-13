<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news'; // not needed, eloquent sucht nach Pluralform vom Klassennamen

  protected $fillable = [
    'title',
    'text',
  ];
}
