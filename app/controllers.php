<?php
$container = $app->getContainer();

$container['HomeController'] = function($c) {
  return new \App\Controllers\HomeController($c);
};
