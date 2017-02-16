<?php

namespace App\Controllers;

use App\Models\User;
use Slim\Views\Twig as View;

class HomeController extends Controller
{

  public function index($request, $response)
  {
    return $this->container->view->render($response, 'welcome.twig', [
        'title' => "Willkommen",
        'active' => "welcome",
    ]);
  }

  public function contact($request, $response)
  {
    return $this->container->view->render($response, 'contact.twig', [
        'title' => "Kontakt",
        'active' => "contact",
    ]);
  }

  public function approach($request, $response)
  {
    return $this->container->view->render($response, 'approach.twig', [
        'title' => "Anfahrt & Öffnungszeiten",
        'active' => "approach",
    ]);
  }
}
