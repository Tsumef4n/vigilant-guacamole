<?php

namespace App\Controllers;

use Slim\Views\Twig as View;

class HomeController extends Controller
{

  public function index($request, $response)
  {

    // $user = $this->container->db->table('users')->get();
    // $user = $this->container->db->table('users')->find(1);
    // var_dump($user);
    // die();

    return $this->container->view->render($response, 'welcome.twig', [
        'title' => "Willkommen",
        'active' => "welcome",
    ]);
  }

}
