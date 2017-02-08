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

$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'welcome.twig', [
        'title' => "Willkommen im Schüsterwinkel!",
        'active' => "welcome",
    ]);
})->setName('welcome');
