<?php
// Routes

// $app->get('/', App\Action\HomeAction::class)
//     ->setName('homepage');

$app->get('/contact', function ($request, $response, $args) {
    return $this->view->render($response, 'contact.twig', [
        'title' => "Kontaktformular",
        'active' => "contact",
    ]);
})->setName('contact');

$app->get('/approach', function ($request, $response, $args) {
    return $this->view->render($response, 'approach.twig', [
        'title' => "Anfahrt & Öffnungszeiten",
        'active' => "approach",
    ]);
})->setName('approach');

$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'welcome.twig', [
        'title' => "Willkommen",
        'active' => "welcome",
    ]);
})->setName('welcome');
