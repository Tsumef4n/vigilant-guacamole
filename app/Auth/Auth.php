<?php

namespace App\Auth;

use App\Models\User;

class Auth
{

  public function user()
  {
    if (isset($_SESSION['user']))
    {
      return User::find($_SESSION['user']);
    }
    return false;
  }

  public function check()
  {
    return isset($_SESSION['user']);
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
