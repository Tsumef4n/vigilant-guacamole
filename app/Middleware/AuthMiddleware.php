<?php

namespace App\Middleware;

class AuthMiddleware extends Middleware
{
  public function __invoke($request, $response, $next)
  {
    if (!$this->container->auth->check())
    {
      $this->container->flash->addMessage('error', 'Sie sind nicht eingeloggt! Kein Zugriff auf die angeforderte Seite!');
      return $response->withRedirect($this->container->router->pathFor('auth.login'));
    }

    $response = $next($request, $response);
    return $response;
  }
}
