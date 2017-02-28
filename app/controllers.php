<?php
$container = $app->getContainer();

$container['HomeController'] = function($c) {
  return new \App\Controllers\HomeController($c);
};

$container['ShopController'] = function($c) {
  return new \App\Controllers\ShopController($c);
};

$container['AuthController'] = function($c) {
  return new \App\Controllers\Auth\AuthController($c);
};

$container['AdminController'] = function($c) {
  return new \App\Controllers\AdminController($c);
};

$container['PasswordController'] = function($c) {
  return new \App\Controllers\Auth\PasswordController($c);
};
