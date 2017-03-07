<?php

namespace App\Controllers;

use Slim\Views\Twig as View;

class HomeController extends Controller
{
    public function index($request, $response)
    {
        return $this->container->view->render($response, 'welcome.twig', [
        'title' => 'Willkommen',
        'active' => 'welcome',
    ]);
    }

    public function onepage($request, $response)
    {
        return $this->container->view->render($response, 'onepage.twig', [
      'title' => 'Allgemeines auf einer Seite',
      'active' => 'onepage',
    ]);
    }

    public function impressum($request, $response)
    {
        return $this->container->view->render($response, 'impressum.twig', [
        'title' => 'Impressum',
        'active' => 'impressum',
    ]);
    }

    public function approach($request, $response)
    {
        return $this->container->view->render($response, 'approach.twig', [
        'title' => 'Anfahrt & Öffnungszeiten',
        'active' => 'approach',
    ]);
    }
}
