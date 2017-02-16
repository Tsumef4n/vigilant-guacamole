<?php

namespace App\Middleware;

class GuestMiddleware extends Middleware
{
  public function __invoke($request, $response, $next)
  {
    if ($this->container->auth->check())
    {
      $this->container->flash->addMessage('error', 'Sie sind eingeloggt! Kein Zugriff auf die angeforderte Seite!');
      return $response->withRedirect($this->container->router->pathFor('welcome'));
    }

    $response = $next($request, $response);
    return $response;
  }
}
