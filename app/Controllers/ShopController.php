<?php

namespace App\Controllers;

use App\Models\User;
use Slim\Views\Twig as View;

class ShopController extends Controller
{
  public function stock($request, $response)
  {
    return $this->container->view->render($response, 'shop.list.twig', [
          'title' => "Warenangebot",
          'active' => "stock",
      ]);
  }
}
