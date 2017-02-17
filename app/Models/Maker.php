<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maker extends Model
{
  protected $table = 'makers'; // not needed, eloquent sucht nach Pluralform vom Klassennamen

  protected $fillable = [
    'name',
  ];

  public function setName($name)
  {
    $this->update([
      'name' => $name
    ]);
  }
};
