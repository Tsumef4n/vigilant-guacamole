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
    $this->get('/admin/news[/{id}]', 'AdminController:getNewsList')->setName('admin.news');

    $this->get('/admin/shop[/{id}]', 'AdminController:getShopList')->setName('admin.shop');
    $this->post('/admin/shop', 'AdminController:postShopNewProduct');
    $this->post('/admin/shop/{id}', 'AdminController:putShopUpdateProduct');

    $this->get('/admin/kulinarisches[/{id}]', 'AdminController:getKulinarischesList')->setName('admin.kulinarisches');

    $this->get('/admin/press[/{id}]', 'AdminController:getPressList')->setName('admin.press');

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
$app->get('/impressum', 'HomeController:impressum')->setName('impressum');

$app->get('/news[/{page}]', 'HomeController:news')->setName('news');
$app->get('/stock[/{id}]', 'ShopController:stock')->setName('stock');
$app->get('/kulinarisches', 'HomeController:kulinarisches')->setName('kulinarisches');
$app->get('/aboutUs', 'HomeController:aboutUs')->setName('aboutUs');
$app->get('/press', 'HomeController:press')->setName('press');
$app->get('/guestbook', 'GuestbookController:getList')->setName('guestbook');
$app->post('/guestbook', 'GuestbookController:postNewEntry');
$app->get('/approach', 'HomeController:approach')->setName('approach');

// $app->get('/test', function ($request, $response, $args) {
//   return $this->view->render($response, 'index.html');
// });
$app->get('/onepage', 'HomeController:onepage')->setName('onepage');

$app->get('/', 'HomeController:index')->setName('welcome');
