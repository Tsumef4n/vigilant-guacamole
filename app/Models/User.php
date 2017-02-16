<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  protected $table = 'users'; // not needed, eloquent sucht nach Pluralform vom Klassennamen

  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  public function setPassword($password)
  {
    $this->update([
      'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
  }
};
