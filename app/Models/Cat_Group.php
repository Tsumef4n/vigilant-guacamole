<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cat_Group extends Model
{
    protected $table = 'cat_groups'; // not needed, eloquent sucht nach Pluralform vom Klassennamen

  protected $fillable = [
    'name',
  ];

    public function setName($name)
    {
        $this->update([
      'name' => $name,
    ]);
    }
}
