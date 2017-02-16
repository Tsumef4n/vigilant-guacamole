<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class PasswordController extends Controller
{
  public function getChangePassword($request, $response)
  {
    return $this->container->view->render($response, 'auth/password/change.twig', [
            'title' => "Password ändern",
            'active' => "password.change",
            ]);
  }

  public function postChangePassword($request, $response)
  {
    $validation = $this->container->validator->validate($request, [
      'password_old' => v::noWhitespace()->notEmpty()->matchesPassword($this->container->auth->user()->password),
      'password' => v::noWhitespace()->notEmpty(),
    ]);

    if ($validation->failed())
    {
      $_SESSION['errors']['failedLogin'] = ['Altes Passwort falsch'];
      return $response->withRedirect($this->container->router->pathFor('auth.password.change'));
    }

    $this->container->auth->user()->setPassword($request->getParam('password'));

    $this->container->flash->addMessage('info', 'Passwort erfolgreich geändert!');

    return $response->withRedirect($this->container->router->pathFor('welcome'));
  }
}
