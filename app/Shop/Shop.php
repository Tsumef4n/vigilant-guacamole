<?php

namespace App\Shop;

use App\Models\Maker;

class Shop
{

  public function user()
  {
    if (isset($_SESSION['user']))
    {
      return User::find($_SESSION['user']);
    }
    return false;
  }

  public function attempt($email, $password)
  {
    // get user by email
    $user = User::where('email', $email)->first();
    // check if user found
    if (!$user) { return false; }
    // vertify password
    if(password_verify($password, $user->password))
    {
      // set to session
      $_SESSION['user'] = $user->id;
      return true;
    }
    // password not matching
    return false;
  }

}
