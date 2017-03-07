<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; // not needed, eloquent sucht nach Pluralform vom Klassennamen

    protected $fillable = [
      'name',
      'parent',
    ];

    public function group()
    {
        return $this->belongsTo('App\Models\Cat_Group', 'parent', 'id');
    }

    public function setName($name)
    {
        $this->update([
      'name' => $name,
    ]);
    }
}
