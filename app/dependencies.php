<?php
// DIC configuration

use Respect\Validation\Validator as v;

$container = $app->getContainer();


// Load Eloquent
$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($c) use ($capsule) {
    return $capsule;
};

// Request Validator
$container['validator'] = function ($c) {
  return new App\Validation\Validator;
};

// Add custom rule to validator
v::with('App\\Validation\\Rules\\');

// Csrf
$container['csrf'] = function ($c) {
  return new Slim\Csrf\Guard;
};

// Auth
$container['auth'] = function ($c) {
  return new App\Auth\Auth;
};

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Flash messages
$container['flash'] = function ($c) {
    return new Slim\Flash\Messages;
};

// Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    $view->getEnvironment()->addGlobal('auth', [
      'check' => $c->auth->check(),
      'user' => $c->auth->user(),
    ]);

    $view->getEnvironment()->addGlobal('flash', $c->flash);

    return $view;
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['logger']['path'], Monolog\Logger::DEBUG));
    return $logger;
};
