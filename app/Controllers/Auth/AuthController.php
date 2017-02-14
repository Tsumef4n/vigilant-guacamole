<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;

class AuthController extends Controller
{
  public function getRegister($request, $response)
  {
    return $this->container->view->render($response, 'auth/register.twig');
  }

  public function postRegister($request, $response)
  {
    $user = User::create([
      'name' => $request->getParam('inputName'),
      'email' => $request->getParam('inputEmail'),
      'password' => password_hash($request->getParam('inputPassword'), PASSWORD_DEFAULT),
    ]);

    return $response->withRedirect($this->container->router->pathFor('welcome'));
  }
}
