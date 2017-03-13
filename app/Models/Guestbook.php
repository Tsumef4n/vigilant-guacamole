<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guestbook extends Model
{
    protected $table = 'guestbook'; // not needed, eloquent sucht nach Pluralform vom Klassennamen

  protected $fillable = [
    'name',
    'email',
    'text',
  ];
}
