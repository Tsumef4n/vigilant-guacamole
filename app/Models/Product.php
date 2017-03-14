<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // not needed, eloquent sucht nach Pluralform vom Klassennamen

  protected $fillable = [
    'name',
    'description',
    'image',
    'maker_id',
  ];

    public function maker()
    {
        return $this->belongsTo('App\Models\Maker', 'maker_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'maker_id', 'id');
    }
}
