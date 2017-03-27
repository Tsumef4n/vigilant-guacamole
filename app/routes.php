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
    // News Routing
    $this->get('/admin/news/list', 'AdminController:getNewsList')->setName('admin.news.list');
    $this->get('/admin/news/edit/{id}', 'AdminController:getNewsEdit')->setName('admin.news.edit');
    $this->post('/admin/news/edit/{id}', 'AdminController:postNewsEdit');
    $this->get('/admin/news/new', 'AdminController:getNewsNew')->setName('admin.news.new');
    $this->post('/admin/news/new', 'AdminController:postNewsNew');
    // Shop Routing
    $this->get('/admin/shop/list[/{id}]', 'AdminController:getShopList')->setName('admin.shop.list');
    $this->get('/admin/shop/edit/{id}', 'AdminController:getShopEdit')->setName('admin.shop.edit');
    $this->post('/admin/shop/edit/{id}', 'AdminController:postShopEdit');
    $this->get('/admin/shop/new', 'AdminController:getShopNew')->setName('admin.shop.new');
    $this->post('/admin/shop/new', 'AdminController:postShopNew');
    // Kulinarisches Routing
    $this->get('/admin/kulinarisches', 'AdminController:getKulinarisches')->setName('admin.kulinarisches');
    $this->post('/admin/kulinarisches', 'AdminController:postKulinarisches');
    $this->post('/admin/kulinarisches/new/{month}/{year}', 'AdminController:postKulinarischesNew')->setName('admin.kulinarisches.new');
    $this->post('/admin/kulinarisches/edit/{id}/{month}/{year}', 'AdminController:postKulinarischesEdit')->setName('admin.kulinarisches.edit');
    // Presse Routing
    $this->get('/admin/press/list', 'AdminController:getPressList')->setName('admin.press.list');
    $this->get('/admin/press/edit/{id}', 'AdminController:getPressEdit')->setName('admin.press.edit');
    $this->post('/admin/press/edit/{id}', 'AdminController:postPressEdit');
    $this->get('/admin/press/new', 'AdminController:getPressNew')->setName('admin.press.new');
    $this->post('/admin/press/new', 'AdminController:postPressNew');

    $this->post('/admin/guestbook/{id}', 'AdminController:postGuestbookDelete')->setName('admin.guestbook.delete');
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
$app->get('/kulinarisches', 'HomeController:getKulinarisches')->setName('kulinarisches');
$app->post('/kulinarisches', 'HomeController:postKulinarisches');
$app->get('/aboutUs', 'HomeController:aboutUs')->setName('aboutUs');
$app->get('/press[/{page}]', 'HomeController:press')->setName('press');
$app->get('/guestbook[/{page}]', 'GuestbookController:getList')->setName('guestbook');
$app->post('/guestbook', 'GuestbookController:postNewEntry');
$app->get('/approach', 'HomeController:approach')->setName('approach');

// $app->get('/test', function ($request, $response, $args) {
//   return $this->view->render($response, 'index.html');
// });
$app->get('/onepage', 'HomeController:onepage')->setName('onepage');

$app->get('/picupload', 'HomeController:test')->setName('test');

$app->get('/', 'HomeController:index')->setName('welcome');
