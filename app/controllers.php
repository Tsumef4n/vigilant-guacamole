<?php
$container = $app->getContainer();

$container['HomeController'] = function($c) {
  return new \App\Controllers\HomeController($c);
};

$container['AuthController'] = function($c) {
  return new \App\Controllers\Auth\AuthController($c);
};
