<?php
// Routes


// $app->get('/login', function ($request, $response, $args) {
//     return $this->view->render($response, 'auth/login.twig', [
//         'title' => "Login",
//         'active' => "login",
//     ]);
// })->setName('login');

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

$app->get('/auth/login', 'AuthController:getLogin')->setName('auth.login');
$app->post('/auth/login', 'AuthController:postLogin');

$app->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
$app->post('/auth/password/change', 'PasswordController:postChangePassword');

$app->get('/auth/logoff', 'AuthController:getLogoff')->setName('auth.logoff');

$app->get('/', 'HomeController:index')->setName('welcome');
