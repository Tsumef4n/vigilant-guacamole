<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
$container = $app->getContainer();

$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
$app->add(new \App\Middleware\CsrfViewMiddleware($container));

$app->add($container->csrf);
