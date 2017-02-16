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

$app->get('/stock', function ($request, $response, $args) {
    return $this->view->render($response, 'shop.list.twig', [
        'title' => "Warenangebot",
        'active' => "stock",
    ]);
})->setName('stock');

$app->get('/contact', function ($request, $response, $args) {
    return $this->view->render($response, 'contact.twig', [
        'title' => "Kontakt",
        'active' => "contact",
    ]);
})->setName('contact');

$app->get('/approach', function ($request, $response, $args) {
    return $this->view->render($response, 'approach.twig', [
        'title' => "Anfahrt & Öffnungszeiten",
        'active' => "approach",
    ]);
})->setName('approach');

// $app->get('/', function ($request, $response, $args) {
//     return $this->view->render($response, 'welcome.twig', [
//         'title' => "Willkommen",
//         'active' => "welcome",
//     ]);
// })->setName('welcome');

$app->get('/auth/register', 'AuthController:getRegister')->setName('auth.register');
$app->post('/auth/register', 'AuthController:postRegister');



// Routen nur fuer bestimmte Gruppen freigeben
$app->group('', function () {
    $this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', 'PasswordController:postChangePassword');

    $this->get('/auth/logoff', 'AuthController:getLogoff')->setName('auth.logoff');
})->add(new AuthMiddleware($container));

// Guest = nicht angemeldet -> angemeldete User sollen nicht nochmal auf die anmelden-Seite
$app->group('', function () {
    $this->get('/auth/login', 'AuthController:getLogin')->setName('auth.login');
    $this->post('/auth/login', 'AuthController:postLogin');
})->add(new GuestMiddleware($container));

$app->get('/', 'HomeController:index')->setName('welcome');
