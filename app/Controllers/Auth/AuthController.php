<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{
  public function getLogoff($request, $response)
  {
    $this->container->auth->logout();
    return $response->withRedirect($this->container->router->pathFor('welcome'));
  }

  public function getLogin($request, $response)
  {
    return $this->container->view->render($response, 'auth/login.twig', [
            'title' => "Login",
            'active' => "login",
        ]);
  }

  public function postLogin($request, $response)
  {
    $auth = $this->container->auth->attempt(
      $request->getParam('email'),
      $request->getParam('password')
    );

    if (!$auth)
    {
      $_SESSION['errors']['failedLogin'] = ['E-Mail oder Passwort falsch'];
      $this->container->flash->addMessage('error', 'Anmeldung fehlgeschlagen');
      return $response->withRedirect($this->container->router->pathFor('auth.login'));
    }

    return $response->withRedirect($this->container->router->pathFor('welcome'));
  }


  public function getRegister($request, $response)
  {
    return $this->container->view->render($response, 'auth/register.twig', [
            'title' => "Register",
            'active' => "register",
            ]);
  }

  public function postRegister($request, $response)
  {
    $validation = $this->container->validator->validate($request, [
      'name' => v::notEmpty()->alpha(),
      'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
      'password' => v::noWhitespace()->notEmpty(),
    ]);

    if ($validation->failed())
    {
      return $response->withRedirect($this->container->router->pathFor('auth.register'));
    }

    // getParam uses name of element, not the id
    $user = User::create([
      'name' => $request->getParam('name'),
      'email' => $request->getParam('email'),
      'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
    ]);

    $this->container->flash->addMessage('info', 'Registrierung erfolgreich!');

    $this->container->auth->attempt($user->email, $request->getParam('password'));

    return $response->withRedirect($this->container->router->pathFor('welcome'));
  }
}
