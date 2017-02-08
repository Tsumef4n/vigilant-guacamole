<?php
// Routes

// $app->get('/', App\Action\HomeAction::class)
//     ->setName('homepage');

$app->get('/contact', function ($request, $response, $args) {
    return $this->view->render($response, 'contact.twig', [
        'title' => "Kontaktformular"
    ]);
})->setName('contact');

$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'home.twig', [
        'title' => "Titel der Webseite"
    ]);
})->setName('homepage');
