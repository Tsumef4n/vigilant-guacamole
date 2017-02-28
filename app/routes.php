<?php
// Routes

// $app->get('/login', function ($request, $response, $args) {
//     return $this->view->render($response, 'auth/login.twig', [
//         'title' => "Login",
//         'active' => "login",
//     ]);
// })->setName('login');

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

// Routen nur fuer bestimmte Gruppen freigeben
$app->group('', function () {
    $this->get('/admin/list[/{id}]', 'AdminController:getList')->setName('admin.list');
    $this->post('/admin/list', 'AdminController:postNewProduct');
    $this->post('/admin/list/{id}', 'AdminController:putUpdateProduct');

    // Nur User sollen User erstellen koennen
    $this->get('/auth/register', 'AuthController:getRegister')->setName('auth.register');
    $this->post('/auth/register', 'AuthController:postRegister');

    $this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', 'PasswordController:postChangePassword');

    $this->get('/auth/logoff', 'AuthController:getLogoff')->setName('auth.logoff');
})->add(new AuthMiddleware($container));

// Guest = nicht angemeldet -> angemeldete User sollen nicht nochmal auf die anmelden-Seite
$app->group('', function () {
    $this->get('/auth/login', 'AuthController:getLogin')->setName('auth.login');
    $this->post('/auth/login', 'AuthController:postLogin');
})->add(new GuestMiddleware($container));

// Ohne Gruppe -> fuer alle sichtbar
$app->get('/contact', 'HomeController:contact')->setName('contact');
$app->get('/approach', 'HomeController:approach')->setName('approach');

$app->get('/stock[/{id}]', 'ShopController:stock')->setName('stock');

// $app->get('/test', function ($request, $response, $args) {
//   return $this->view->render($response, 'index.html');
// });

$app->get('/', 'HomeController:index')->setName('welcome');
